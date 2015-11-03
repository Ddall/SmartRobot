<?php
namespace Dr\ReaderBundle\Service;

/**
 * @author Allan
 */

use Dr\ReaderBundle\Service\AbstractDdxHelper;

abstract class AbstractDdxDrService extends AbstractDdxHelper{

    // REPOSITORIES
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getMarketRepository(){
        return $this->getManager()->getRepository('DdxDrMarketBundle:Market');
    }
    
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getTradeRepository(){
        return $this->getManager()->getRepository('DdxDrMarketBundle:Trade');
    }
    
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getTradingPairRepository(){
        return $this->getManager()->getRepository('DdxDrMarketBundle:TradingPair');
    }
    
}
