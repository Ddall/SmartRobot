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


        return $this->render('WebBundle:TradingPair:show.html.twig', array(
            'tradingPair' => $tradingPair,
            'formTradingPair'   => $formTradingPair->createView(),
        ));
    }


    /**
     * @return BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }
}
