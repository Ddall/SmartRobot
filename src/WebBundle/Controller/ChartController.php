<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 11/11/2015
 * Time: 23:52
 */

namespace WebBundle\Controller;


use Dr\MarketBundle\Entity\TradingPair;
use Dr\ReaderBundle\Service\BaseHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChartController extends Controller{

    /**
     * @param Request $request
     * @param $market_id
     * @return string
     */
    public function tradeHistoryAction(Request $request, $tradingPair_id = 0){
        $tradingPair = $this->getHelper()->getTradingPairRepository()->findOneBy(array(
            'id' => $tradingPair_id,
        ));

        if(false === $tradingPair instanceof TradingPair){
            throw new \Exception('wrong parameter or id');
        }

        $data = $this->getHelper()->getTradeRepository()->getWeightedData($tradingPair->getMarket(), $tradingPair);
        $norm = $this->normalizeData($data);

        return new Response(json_encode($norm));
    }

    /**
     * @param Request $request
     * @param int $tradingPair_id
     * @return Response
     * @throws \Exception
     */
    public function tradeHistoryOHLCAction($tradingPair_id = 0){
        $tradingPair = $this->getHelper()->getTradingPairRepository()->findOneBy(array(
            'id' => $tradingPair_id,
        ));

        if(false === $tradingPair instanceof TradingPair){
            throw new \Exception('wrong parameter or id');
        }

        $ohlc = $this->getHelper()->getTradeRepository()->getOHLCData($tradingPair->getMarket(), $tradingPair);

        $norm = $this->normalizeOHLC($ohlc);

        return new Response(json_encode($norm));
    }


    /**
     * @param array $data
     * @return array
     */
    private function normalizeData(array $data){
        $output = array();

        foreach($data as $line){
            $data[] = array(
                (integer)$line['period_unix'] *1000,
                (float)$line['vwap'],
            );
        }

        return $output;
    }


    /**
     * @param array $ohlc
     * @return array
     */
    private function normalizeOHLC(array $ohlc){
        $data = array();
        foreach($ohlc as $key => $line){
            $data[] = array(
                (integer)$line['period_unix'] *1000, // *1000 to add trailing zeroes
                (float)$line['open'],
                (float)$line['high'],
                (float)$line['low'],
                (float)$line['close'],
                (float)$line['volume'],
            );
        }

        return $data;
    }



    /**
     * @return BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }

}
