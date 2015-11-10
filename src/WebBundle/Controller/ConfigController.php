<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 09/11/2015
 * Time: 08:06
 */

namespace WebBundle\Controller;


use Dr\MarketBundle\Form\AssetType;
use Dr\ReaderBundle\Service\BaseHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConfigController extends Controller{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function assetAction(Request $request){
        $entities = $this->getHelper()->getAssetRepository()->findAll();

        $assets = array();
        foreach($entities as $key => $entity){
            $assets[$key]['entity'] = $entity;
            $assets[$key]['form'] = $this->createForm( new AssetType(), $entity);
            $assets[$key]['formView'] = $assets[$key]['form']->createView();

        }

        // Handle request
        foreach($assets as $asset){
            $asset['form']->handleRequest($request);

            if($asset['form']->isSubmitted()){

                if( $asset['form']->isValid() ){
                    $em = $this->getDoctrine()->getEntityManager();
                    $asset = $asset['form']->getData();
                    $em->persist($asset);
                    $em->flush();
                    break;
                }

                return $this->redirectToRoute('dr_config_asset');
            }
        }


        return $this->render('WebBundle:Config:asset.html.twig', array(
            'assets' => $assets,
        ));
    }

    /**
     * @return BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }

}
