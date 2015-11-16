<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 09/11/2015
 * Time: 08:06
 */

namespace WebBundle\Controller;


use Dr\MarketBundle\Entity\Asset;
use Dr\MarketBundle\Form\AssetType;
use Dr\ReaderBundle\Service\BaseHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function assetAction(Request $request){
        $entities = $this->getHelper()->getAssetRepository()->findAll();

        $assets = array();
        foreach($entities as $key => $entity){
            $assets[$key]['entity'] = $entity;
            $assets[$key]['form'] = $this->createForm( new AssetType(), $entity, array(
                'action' => $this->generateUrl('dr_settings_asset_edit', array(
                    'asset_id' => $entity->getId(),
                )),
            ));
            $assets[$key]['formView'] = $assets[$key]['form']->createView();
        }

        return $this->render('WebBundle:Settings:asset.html.twig', array(
            'assets' => $assets,
        ));
    }


    /**
     * @param Request $request
     * @param $asset_id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function editAssetAction(Request $request, $asset_id){

        $asset = $this->getHelper()->getAssetRepository()->findOneBy(array(
            'id' => $asset_id,
        ));

        if(false === $asset instanceof Asset){
            throw new \Exception('invalid parameter or id');
        }

        $form = $this->createForm( new AssetType(), $asset, array(
            'action' => $this->generateUrl('dr_settings_asset_edit', array(
                'asset_id' => $asset->getId(),
            )),
        ));

        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $form->getData();
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirectToRoute('dr_settings_asset');
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAssetAction(Request $request){

        $form = $this->createForm( new AssetType() );
        $form->handleRequest($request);

        if($form->isValid()){
            $asset = $form->getData();
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($asset);
            $em->flush();

            return $this->redirectToRoute('dr_settings_asset');
        }

        return $this->render('WebBundle:Settings:new_asset.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @param Request $request
     * @param $asset_id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function deleteAssetAction(Request $request, $asset_id){
        $asset = $this->getHelper()->getAssetRepository()->findOneBy(array(
           'id' => $asset_id,
        ));

        if(false === $asset instanceof Asset){
            throw new \Exception('wrong parameter or id');
        }

        $em = $this->getDoctrine()->getManager();
        $em->detach($asset);
        $em->flush();

        return $this->redirectToRoute('dr_settings_asset');
    }


    //-- Refresher

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function refresherAction(Request $request){
        return $this->render('WebBundle:Settings:refresher.html.twig', array(

        ));
    }

    /**
     * @return BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }

}
