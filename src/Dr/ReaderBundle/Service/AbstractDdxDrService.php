<?php
namespace Dr\ReaderBundle\Service;

/**
 * @author Allan
 */

use Composer\Repository\RepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Dr\MarketBundle\Entity\TradeRepository;
use Dr\MarketBundle\Entity\TradingPairRepository;

abstract class AbstractDdxDrService extends AbstractDdxHelper{

    // REPOSITORIES
    /**
     * @return RepositoryInterface
     */
    public function getMarketRepository(){
        return $this->getManager()->getRepository('DrMarketBundle:Market');
    }

    /**
     * @return TradeRepository
     */
    public function getTradeRepository(){
        return $this->getManager()->getRepository('DrMarketBundle:Trade');
    }
    
    /**
     * @return TradingPairRepository
     */
    public function getTradingPairRepository(){
        return $this->getManager()->getRepository('DrMarketBundle:TradingPair');
    }


    /**
     * @return ObjectRepository
     */
    public function getAssetRepository(){
        return $this->getManager()->getRepository('DrMarketBundle:Asset');
    }

    /**
     * @return ObjectRepository
     */
    public function getStrategiesRepository(){
        return $this->getManager()->getRepository('DrStrategyBundle:Strategy');
    }
    
}
