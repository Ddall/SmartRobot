<?php

namespace Dr\ReaderBundle\Service;

/**
 * @author Allan
 */

use Dr\ReaderBundle\Service\AbstractDdxDrService;

use Dr\ReaderBundle\Market\AbstractMarket;

abstract class AbstractMarketService extends AbstractDdxDrService{
    
    /**
     * @var AbstractMarket
     */
    protected $api;
    
    /**
     * @param boolean $dryrun
     * @throws \Exception
     */
    public function updateAllTradeHistory($dryrun = false){
        throw new \ Exception('You must overload AbstractMarket::setApi()');
    }
    
}
