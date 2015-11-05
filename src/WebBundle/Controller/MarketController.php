<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 04/11/2015
 * Time: 06:14
 */

namespace WebBundle\Controller;


use Dr\MarketBundle\Entity\Market;
use Dr\ReaderBundle\Service\BaseHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MarketController extends Controller{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request){

        $markets = $this->getHelper()->getMarketRepository()->findAll();

        return $this->render('WebBundle:Market:list.html.twig', array(
            'markets'   => $markets
        ));
    }

    /**
     * @param Request $request
     * @param integer $market_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, $market_id){

        $market = $this->getHelper()->getMarketRepository()->findOneBy(array(
            'id' => $market_id
        ));

        if(false === $market instanceof  Market){
            throw new NotFoundHttpException('invalid market id');
        }

        return $this->render('WebBundle:Market:show.html.twig', array(
            'market' => $market,
        ));
    }

    /**
     * @return BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }

}
