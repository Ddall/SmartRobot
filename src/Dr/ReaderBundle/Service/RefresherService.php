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
     * @param array $arrayMarkets
     * @throws \Exception
     */
    private function checkMarketsArray(array $arrayMarkets){
        foreach($arrayMarkets as $market){
            if(!is_object($market) || false === $market instanceof AbstractMarketService ){
                throw new \Exception('expecting AbstractMarketService, got ' . gettype($market));
            }else{
                $this->markets[] = $market;
            }
        }
    }


    public function refresh(){
        foreach($this->markets as $market){
            $market->updateAllTradeHistory(false);
            $market->updateAllOrderBook(false);
        }
    }

    /**
     * Alias of refresh()
     */
    public function run(){
        return $this->refresh();
    }
}
