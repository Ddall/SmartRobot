<?php
namespace Dr\StrategyBundle\Service\Cruncher;

/**
 * EMACruncher
 *
 * @author Allan
 */
use Dr\StrategyBundle\Service\AbstractCruncherService;
use Dr\ReaderBundle\Market;
use Dr\MarketBundle\Entity\TradingPair;

class EMACruncher extends AbstractCruncherService{

    const WORK_PERIOD = 1;

    /**
     * 
     * @param Market $market
     * @param TradingPair $tradingPair
     * @param type $parameters
     */
    public function work(Market $market, TradingPair $tradingPair, $parameters = array() ){
        
    }
    
    protected function handleParameters($parameters){
        if(!is_array($parameters)){
            throw new \Exception('EmaCruncher::handleParameters wrong format');
        }
        
        if(!array_key_exists(self::WORK_PERIOD, $parameters)){
            $parameters[self::WORK_PERIOD] = null;
        }
    }
}
