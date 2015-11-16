<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 05/11/2015
 * Time: 07:57
 */

namespace Dr\ReaderBundle\Service;



class RefresherService{

    /**
     * @var array
     */
    private $markets;

    /**
     * RefresherService constructor.
     * @param array $markets
     */
    public function __construct(array $markets){
        $this->checkMarketsArray($markets);
        $this->markets = $markets;
    }

    /**
     * Checks and registers arrayMarket
     * @param array $arrayMarkets
     * @throws \Exception
     */
    private function checkMarketsArray(array $arrayMarkets){
        foreach($arrayMarkets as $market){
            if(!is_object($market) || false === $market instanceof MarketServiceInterface ){
                throw new \Exception('expecting AbstractMarketService, got ' . gettype($market));
            }else{
                $this->markets[] = $market;
            }
        }
    }


    /**
     * @param bool|false $dryrun
     * @return array
     */
    public function refresh($force = false, $dryrun = false){
        $output = array();

        foreach($this->markets as $market){

            $output[$market->getName()]['tradehistory'] = $market->updateAllTradeHistory($force, $dryrun);
            $output[$market->getName()]['orderbook'] = $market->updateAllOrderBook($force, $dryrun);
        }

        return $output;
    }

    /**
     * Alias of refresh()
     * @param bool|false $dryrun
     * @return array
     */
    public function run($dryrun = false){
        return $this->refresh($dryrun);
    }

}
