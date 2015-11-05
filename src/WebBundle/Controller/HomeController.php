<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 03/11/2015
 * Time: 15:02
 */

namespace WebBundle\Controller;


use Dr\ReaderBundle\Service\BaseHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request){

        return $this->render('WebBundle:Default:home.html.twig',array(

            )
        );
    }


    /**
     * @return BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }

}
