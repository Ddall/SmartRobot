<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 04/11/2015
 * Time: 20:21
 */

namespace WebBundle\Controller;


use Dr\MarketBundle\Form\Type\TradingPairType;
use Dr\ReaderBundle\Service\BaseHelper;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Zend\Json\Expr;

class TradingPairController extends Controller{

    /**
     * @param Request $request
     * @param $tradingPair_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $tradingPair_id){
        $tradingPair = $this->getHelper()->getTradingPairRepository()->findOneBy(array(
            'id' => $tradingPair_id
        ));

        $formTradingPair = $this->createForm(new TradingPairType(), $tradingPair);

        $formTradingPair->handleRequest($request);

        if($formTradingPair->isValid()){
            $pair = $formTradingPair->getData();

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($pair);
            $em->flush();
        }



        $ob = $this->getOb();

        return $this->render('WebBundle:TradingPair:show.html.twig', array(
            'tradingPair' => $tradingPair,
            'formTradingPair'   => $formTradingPair->createView(),
            'chart' => $ob,
        ));
    }


    /**
     * @return Highchart
     */
    private function getOb(){
        $series = array(
            array(
                'name'  => 'Rainfall',
                'type'  => 'column',
                'color' => '#4572A7',
                'yAxis' => 1,
                'data'  => array(49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4),
            ),
            array(
                'name'  => 'Temperature',
                'type'  => 'spline',
                'color' => '#AA4643',
                'data'  => array(7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6),
            ),
        );
        $yData = array(
            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return this.value + " degrees C" }'),
                    'style'     => array('color' => '#AA4643')
                ),
                'title' => array(
                    'text'  => 'Temperature',
                    'style' => array('color' => '#AA4643')
                ),
                'opposite' => true,
            ),
            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return this.value + " mm" }'),
                    'style'     => array('color' => '#4572A7')
                ),
                'gridLineWidth' => 0,
                'title' => array(
                    'text'  => 'Rainfall',
                    'style' => array('color' => '#4572A7')
                ),
            ),
        );
        $categories = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

        $ob = new Highchart();
        $ob->chart->renderTo('tradehistory'); // The #id of the div where to render the chart
        $ob->chart->type('column');
        $ob->title->text('Average Monthly Weather Data for Tokyo');
        $ob->xAxis->categories($categories);
        $ob->yAxis($yData);
        $ob->legend->enabled(false);
        $formatter = new Expr('function () {
                 var unit = {
                     "Rainfall": "mm",
                     "Temperature": "degrees C"
                 }[this.series.name];
                 return this.x + ": <b>" + this.y + "</b> " + unit;
             }');
        $ob->tooltip->formatter($formatter);
        $ob->series($series);

        return $ob;
    }


    /**
     * @return BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }
}
