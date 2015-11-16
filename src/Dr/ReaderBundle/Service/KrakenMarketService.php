<?php
namespace Dr\ReaderBundle\Service;

/**
 * @author Allan
 */

use Doctrine\ORM\EntityManagerInterface;
use Dr\MarketBundle\Service\TradeService;
use Dr\MarketBundle\Service\TradingPairService;

use Dr\ReaderBundle\Market\KrakenApiWrapper;
use Dr\MarketBundle\Entity\TradingPair;
use Dr\MarketBundle\Entity\Trade;
use Dr\MarketBundle\Entity\Position;
use Dr\MarketBundle\Entity\OrderBook;
use \Exception as Exception;

class KrakenMarketService extends AbstractDdxDrService implements MarketServiceInterface {

    /**
     * @var KrakenApiWrapper
     */
    protected $api;

    /**
     * Instance of Kraken
     * @var \Dr\MarketBundle\Entity\Market
     */
    protected $_krakenEntity;


    // -- EXPOSED METHODS -- EXPOSED METHODS -- EXPOSED METHODS -- EXPOSED METHODS

    /**
     * @return string
     */
    public function getName(){
        return 'kraken';
    }
    
    /**
     * Call this to update the trade history
     * @param bool|false $force ignore refresh interval
     * @param bool|false $dryrun no persist
     * @return array of number of new Trades saved
     * @throws Exception
     */
    public function updateAllTradeHistory($force = false, $dryrun = false){
        $output = array();
        
        $kraken = $this->getMarketEntity();
        $activePairs = $kraken->getActiveTradingPairs();

        if($force === false){
            foreach($activePairs as $key => $pair){
                if($pair->isStale() !== false){
                    $activePairs[$key];
                }
            }
        }

        foreach($activePairs as $pair){
            $output[$pair->getName()] = $this->updateTradeHistory($pair, $dryrun);
        }

        return $output;
    }
    
    /**
     * Updates the history for a single tradingpair
     * @param TradingPair $pair
     * @param boolean $dryrun
     * @throws Exception
     * @return integer number of new Trades
     */
    public function updateTradeHistory(TradingPair $pair, $dryrun = false){
        if(!$this->api->hasApiCallsLeft()){
            throw new Exception('API LIMIT EXCEEDED');
        }
        
        $lastTrade = $this->getTradeRepository()->getLastTrade($this->getMarketEntity(), $pair);

        if($lastTrade){
            $lastId = $lastTrade->getRemoteId();
        }else{
            $lastId = null;
        }

        $history = $this->readMarketHistory($pair, $lastId);
        if(!array_key_exists('result', $history)){
            throw new Exception('updateTradeHistory: No results from api. data: ' 
                    . print_r($history['error'], true));
        }
        
        $entities = $this->rawToTrades($history['result'][$pair->getRemoteName()], $pair, $history['result']['last']);
        foreach($entities as $e){
            $this->getManager()->persist($e);
        }

        $pair->setRefreshed();
        $this->getManager()->persist($pair);

        if(!$dryrun){
            $this->getManager()->flush();
        }
        
        return count($entities);
    }
    
    /**
     * Use this to update the trading pairs available on Kraken
     * @param boolean $dryrun
     */
    public function updateTradingPairs($dryrun = false){
        $pairsData = $this->api->getTradingPairs();
        $pairsEntities = array();
        $kraken = $this->getMarketEntity();
        
        foreach($pairsData as $name => $pair){
            
            $localPair = $this->getTradingPairRepository()->findOneBy(array(
                'market' => $kraken,
                'remoteName' => $name,
            ));
            
            if($localPair === null){ 
                $pairsEntities[$name] = new TradingPair($kraken, $name, $name);
                $this->getManager()->persist($pairsEntities[$name]);
            }
        }
        
        if(!$dryrun){
            $this->getManager()->flush();
        }else{
            
            foreach($pairsEntities as $e){
                $this->getManager()->refresh($e);
            }
            
        }
        
        return $pairsEntities;
    }
    

    /**
     * Use this to update a single trading pair
     * @param TradingPair $pair
     * @param boolean $dryrun
     * @return array
     */
    public function updateOrderBook(TradingPair $pair, $dryrun = false){
        if(!$pair->isActive()){
            throw new Exception('TRADING PAIR IS NOT ACTIVE');
        }
        
        $orderBook = new OrderBook();
        $orderBook
                ->setMarket($this->getMarketEntity())
                ->setTradingPair($pair)
                ->setRemotetime($this->api->getCurrentTime());
        $this->getManager()->persist($orderBook);
        
        if(!$dryrun){
            $this->getManager()->flush();
        }
        
        $rawOrderBook = $this->readOrderBook($pair, 1000);
        foreach($rawOrderBook[$pair->getRemoteName()]['asks'] as $rawPos){
            $orderBook->addAsk($this->rawToPosition($rawPos));
        }
        
        foreach($rawOrderBook[$pair->getRemoteName()]['bids'] as $rawPos){
            $orderBook->addBid($this->rawToPosition($rawPos));
        }

        $pair->setOrderBookRefreshed();
        $this->getManager()->persist($pair);
        $this->getManager()->persist($orderBook);
        if(!$dryrun){
            $this->getManager()->flush();
        }
        
        return array(
            'asks' => $orderBook->getAsks()->count(),
            'bids' => $orderBook->getBids()->count(),
        );
    }
    

    /**
     * Use this to update the orderbook for all tradingpairs
     * costs 1 point per active pair
     * @param bool|false $force
     * @param bool|false $dryrun
     * @return mixed
     * @throws Exception
     */
    public function updateAllOrderBook($force = false, $dryrun = false){
        $tradingPairs = $this->getMarketEntity()->getActiveTradingPairs();

        if($force === false){
            foreach($tradingPairs as $key => $pair){
                if($pair->isOrderBookStale() !== false){
                    $tradingPairs[$key];
                }
            }
        }

        foreach($tradingPairs as $pair ){
            $output[$pair->getRemoteName()] = $this->updateOrderBook($pair, $dryrun);
        }
        
        return $output;
    }
    

    // -- TOOLS -- TOOLS -- TOOLS -- TOOLS -- TOOLS -- TOOLS -- TOOLS -- TOOLS
    
    /**
     * @param TradingPair $pair
     * @param integer $limit
     * @throws Exception
     * @return array
     */
    protected function readOrderBook(TradingPair $pair, $limit = null){
        $orderBook = $this->api->getOrderBook($pair, $limit);
        if(count($orderBook['error']) !== 0){
            throw new Exception('API ERROR: ' . print_r($orderBook['error'], true));
        }
        return $orderBook['result'];
    }
    
    
    /**
     * Returns the history of a certain market (defined by the tradingpairs)
     * @_todo handle errors
     * @param TradingPair $pair
     * @param string $lastId id of the last trade
     * @return array|null
     */
    protected function readMarketHistory(TradingPair $pair, $lastId){
        if(!$this->api->hasApiCallsLeft()){
            throw new Exception('API CALLS EXECEEDED');
        }
        
        if($pair->isActive()){
            return $this->api->getTradeHistory($pair, $lastId);
        }
        
        return null;
    }
    
    /**
     * Converts raw position from Depth Api to a Position entity
     * @param array $data
     * @return Position
     */
    protected function rawToPosition(array $data){
        $pos = new Position();
        $pos
                ->setPrice($data[0])
                ->setVolume($data[1])
                ->setUnixTimestamp($data[2])
                ;
        return $pos;
    }
    
    
    /**
     * Converts a TWO DIMENSIONNAL ARRAY of API results to an array of Trade entities
     * @param array $rawTrades
     * @param TradingPair $tradingPair
     * @param string $lastId
     * @return array
     */
    private function rawToTrades($rawTrades, TradingPair $tradingPair, $lastId){
        $remoteId = null;
        $output = array();
        
        $len = count($rawTrades) - 1;
        $i = 0;
        foreach($rawTrades as $line){
            if($i == $len){
                $remoteId = $lastId;
            }
            $output[] = $this->rawToTrade($line, $tradingPair, $remoteId);
            $i++;
        }
        
        return $output;
    }

    /**
     * Converts an array from the Api to a Trade entity
     * @param array $rawTrade
     * @param TradingPair $tradingPair
     * @param string $remoteId
     * @return Trade
     */
    private function rawToTrade($rawTrade, TradingPair $tradingPair, $remoteId = null){
    
        $trade = new Trade();
        
        if($rawTrade[3] == 'b'){
            $direction = 'BUY';
        }else{
            $direction = 'SELL';
        }
        
        if($rawTrade[4] == 'l'){
            $orderType = 'LIMIT';
        }else{
            $orderType = 'MARKET';
        }
        
        $trade->setMarket($this->getMarketEntity())
                ->setTradingPair($tradingPair)
                ->setPrice($rawTrade[0])
                ->setVolume($rawTrade[1])
                ->setTimeRemoteFromTimestamp($rawTrade[2])
                ->setDirection($direction)
                ->setOrderType($orderType)
                ->setRemoteId($remoteId)
                ;
        
        return $trade;
    }
    

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Dr\MarketBundle\Service\TradeService $tradeService
     * @param \Dr\MarketBundle\Service\TradingPairService $tradingPairService
     * @param \Dr\ReaderBundle\Service\KrakenMarketService $krakenMarketService
     * @param array $parameters
     */
    public function __construct(
            EntityManagerInterface $entityManager,
            TradeService $tradeService,
            TradingPairService $tradingPairService,
            $parameters
        ) {
        $this
                ->setEntityManager($entityManager)
                ->setTradeService($tradeService)
                ->setTradingPairService($tradingPairService)
                ;
        $this->setApi( new KrakenApiWrapper($parameters));
        
    }
      
    /**
     * @param KrakenApiWrapper $api
     */
    public function setApi(KrakenApiWrapper $api) {
        $this->api = $api;
    }
    
    
    /**
     * @throws Exception
     * @return \Dr\MarketBundle\Entity\Market Instance of Kraken Entity
     */
    protected function getMarketEntity(){
        if($this->_krakenEntity === null){
            $this->_krakenEntity =  $this->getManager()->getRepository('DrMarketBundle:Market')->findOneByName('Kraken');
            if(!$this->_krakenEntity){
                throw new Exception('KrakenMarketService: Market entity was not found');
            }
        }
        
        return $this->_krakenEntity ;
    }
    
}
