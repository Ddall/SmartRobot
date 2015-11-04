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

abstract class AbstractDdxHelper{

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    
    /**
     * @param EntityManagerInterface $entityManager
     * @return \Dr\ReaderBundle\Service\AbstractDdxDrService
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
     * @var TradeService
     */
    protected $tradeService;

    /**
     * @param TradeService $tradeService
     * @return \Dr\ReaderBundle\Service\AbstractDdxDrService
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
     * @var TradingPairService
     */
    protected $tradingPairService;
    
    /**
     * @param TradingPairService $tradingPairService
     * @return \Dr\ReaderBundle\Service\AbstractDdxDrService
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
     * @var KrakenMarketService
     */
    protected $krakenMarketService;
    
    /**
     * @param KrakenMarketService $krakenMarketService
     * @return \Dr\ReaderBundle\Service\AbstractDdxDrService
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
    
}
