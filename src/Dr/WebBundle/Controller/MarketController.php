<?php
namespace Dr\WebBundle\Controller;
/**
 * MarketController.php UTF-8
 * @author Allan IRDEL
 */

use Dr\ReaderBundle\Service\BaseHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MarketController extends Controller {

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function marketsIndexAction(){
        $markets = $this->getHelper()->getMarketRepository()->findAll();
        
        return $this->render('DdxDrWebBundle:Market:marketsIndex.html.twig', array(
            'markets' => $markets
        ));
    }
    
    /**
     * @return BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }
    
}
