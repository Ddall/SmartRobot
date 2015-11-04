<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 04/11/2015
 * Time: 06:14
 */

namespace WebBundle\Controller;


use Dr\ReaderBundle\Service\BaseHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request){
        

        return $this->render('WebBundle:Market:edit.twig.html', array(

        ));
    }

    /**
     * @return BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }

}
