<?php
/**
 * Helper service for DdxDr
 * @author Allan
 */
namespace Dr\ReaderBundle\Service;
use Dr\ReaderBundle\Service\AbstractDdxDrService;

use Doctrine\ORM\EntityManagerInterface;
use Dr\MarketBundle\Service\TradeService;
use Dr\MarketBundle\Service\TradingPairService;
use Dr\ReaderBundle\Service\KrakenMarketService;

class BaseHelper extends AbstractDdxDrService{
    
    /**
     * @param EntityManagerInterface $entityManager
     * @param TradeService $tradeService
     * @param TradingPairService $tradingPairService
     * @param KrakenMarketService $krakenMarketService
     * @return \Dr\ReaderBundle\Service\BaseHelper
     */
    public function __construct(
            EntityManagerInterface $entityManager,
            TradeService $tradeService,
            TradingPairService $tradingPairService,
            KrakenMarketService $krakenMarketService
            ) {
        
        $this
                ->setEntityManager($entityManager)
                ->setTradeService($tradeService)
                ->setTradingPairService($tradingPairService)
                ->setKrakenMarketService($krakenMarketService)
                ;
        return $this;
    }
    
}
