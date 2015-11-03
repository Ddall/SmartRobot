<?php
namespace Dr\WebBundle\Controller;
/**
 * IndexController.php UTF-8
 * @author Allan IRDEL
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highstock;

class IndexController extends Controller{
    
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(){
        
        
        
        return $this->render('DdxDrWebBundle:Index:index.html.twig', array(
        ));
    }
    
    /**
     * route /kraken/history
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function krakenHistoryAction(){
        $kraken = $this->getHelper()->getMarketRepository()->findOneBy(array('name' => 'Kraken'));
        $tradingRepo = $this->getHelper()->getTradeRepository();
        
        $allTrades = $kraken->getTrades();
        $vwap = $tradingRepo->getWeightedData($kraken, $kraken->getActiveTradingPairs()->first(), 300);
        
        $tmp = array();
        foreach($allTrade->toArray()  as $trade){
            $tmp[] = array(
                'x' => $trade->getTimeRemote(),
                'y' => $trade->getVolume(),
            );
        }
        
        return $this->render('DdxDrWebBundle:History:index.html.twig', array(
            'allTrades' => $allTrades,
            'vwapData' => $vwap,
            'graphData' => $tmp,
        ));
    }

    /**
     * route /kraken/ohlc
     * https://github.com/marcaube/ObHighchartsBundle/blob/master/Resources/doc/usage.md
     * http://api.highcharts.com/highstock#series.data
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function krakenOHLCAction(){
        $kraken = $this->getHelper()->getMarketRepository()->find(1);
        $data = $this->getHelper()->getTradeRepository()->getOHLCData($kraken, $kraken->getActiveTradingPairs()->first(), 3600 );
        
        $ohlc = array();
        $volume = array();
        foreach($data as $line){
            $ohlc[] = array(
                (integer) $line['period_unix']*1000,
                (integer) $line['open'],
                (integer) $line['high'],
                (integer) $line['low'],
                (integer) $line['close'],
            );
            
            $volume[] = (integer)$line['volume'];
        }
        
        $series = array(
            'ohlc' => array(
                'name' => 'OHLC',
                'type' => 'candlestick',
                'tooltip' => array(
                    'valueDecimals' => 2,
                ),
                'dataGrouping' => array(
                    'units' => array(
                        array('hour', array(1)),
                        array('day', array(1,3)),
                        array('week', array(1)),
                        array('month', array(1,3,6)),
                        array('year', array(1))
                    )
                ),
                'data' => $ohlc,
            ),
//             http://www.highcharts.com/stock/demo/candlestick-and-volume
            'volume' => array(
                'name' => 'Volume',
                'data' => $volume,
            )
        );
        
        
        $ob = new Highstock();
        $ob->chart->renderTo('linechart');
        $ob->chart->title('Kraken historical data');
        $ob->xAxis->title('Time');
        $ob->yAxis->label('Price');
        $ob->series($series);

        return $this->render('DdxDrWebBundle:History:ohlc.html.twig', array(
            'data' => $data,
            'chart' => $ob,
        ));
    }
    
    /**
     * @return \Dr\ReaderBundle\Service\BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }
}
