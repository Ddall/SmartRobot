<?php
namespace Dr\ReaderBundle\Service;

/**
 * AbstractDdxHelper
 * @author Allan
 */

use Doctrine\ORM\EntityManagerInterface;
use Dr\MarketBundle\Service\TradeService;
use Dr\MarketBundle\Service\TradingPairService;
use Dr\ReaderBundle\Service\KrakenMarketService;
use Dr\StrategyBundle\Service\ComputeService;
use Dr\StrategyBundle\Service\FilterService;

abstract class AbstractDdxHelper{

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var TradeService
     */
    protected $tradeService;

    /**
     * @var TradingPairService
     */
    protected $tradingPairService;

    /**
     * @var KrakenMarketService
     */
    protected $krakenMarketService;

    /**
     * @var ComputeService
     */
    protected $computeService;

    /**
     * @var FilterService
     */
    protected $filterService;
    
    /**
     * @param EntityManagerInterface $entityManager
     * @return AbstractDdxDrService
     */
    protected function setEntityManager($entityManager){
        $this->entityManager = $entityManager;
        return $this;
    }


    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(){
        return $this->entityManager;
    }
    
    /**
     * Shortcut for getEntityManager
     * @return EntityManagerInterface
     */
    public function getManager(){
        return $this->getEntityManager();
    }



    /**
     * @param TradeService $tradeService
     * @return AbstractDdxDrService
     */
    protected function setTradeService(TradeService $tradeService){
        $this->tradeService = $tradeService;
        return $this;
    }
    
    /**
     * @return TradeService
     */
    public function getTradeService(){
        return $this->tradeService;
    }


    
    /**
     * @param TradingPairService $tradingPairService
     * @return AbstractDdxDrService
     */
    protected function setTradingPairService(TradingPairService $tradingPairService){
        $this->tradingPairService = $tradingPairService;
        return $this;
    }
    
    /**
     * @return TradingPairService
     */
    public function getTradingPairService(){
        return $this->tradingPairService;
    }
    

    
    /**
     * @param KrakenMarketService $krakenMarketService
     * @return AbstractDdxDrService
     */
    protected function setKrakenMarketService(KrakenMarketService $krakenMarketService){
        $this->krakenMarketService = $krakenMarketService;
        return $this;
    }

    /**
     * @return KrakenMarketService
     */
    public function getKrakenMarketService(){
        return $this->krakenMarketService;
    }

    /**
     * @param ComputeService $computeService
     * @return $this
     */
    public function setComputeService(ComputeService $computeService){
        $this->computeService = $computeService;
        return $this;
    }

    /**
     * @return ComputeService
     */
    public function getComputeService(){
        return $this->computeService;
    }

    /**
     * @param FilterService $filterService
     * @return $this
     */
    public function setFilterService(FilterService $filterService){
        $this->filterService = $filterService;

        return $this;
    }

    /**
     * @return FilterService
     */
    public function getFilterService(){
        return $this->filterService;
    }
    
}
