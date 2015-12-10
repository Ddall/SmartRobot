<?php
/**
 * DdxSr - StrategyController.php
 * Created by Allan.
 */

namespace WebBundle\Controller;


use Dr\ReaderBundle\Service\BaseHelper;
use Dr\StrategyBundle\Entity\Strategy;
use Dr\StrategyBundle\Form\Type\StrategyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StrategyController extends Controller {

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request){

        $strategies = $this->getHelper()->getStrategiesRepository()->findAll();

        return $this->render('WebBundle:Strategy:list.html.twig', array(
            'strategies' => $strategies,
        ));
    }

    /**
     * @param Request $request
     * @param         $strategy_id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function showAction(Request $request, $strategy_id){

        $strategy = $this->getHelper()->getStrategiesRepository()->findOneBy(array(
            'id' => $strategy_id,
        ));

        if(false === $strategy instanceof Strategy){
            throw new \Exception('invalid strategy id');
        }

        return $this->render('WebBundle:Strategy:show.html.twig', array(
            'strategy' => $strategy,
        ));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request){
        $formStrategy = $this->createForm( new StrategyType());

        $formStrategy->handleRequest($request);
        if($formStrategy->isSubmitted() && $formStrategy->isValid()){
            $em = $this->getHelper()->getEntityManager();
            $strategy = $formStrategy->getData();
            $em->persist($strategy);
            $em->flush();

            return $this->redirectToRoute('dr_strategy_list');
        }

        return $this->render('WebBundle:Strategy:add.html.twig', array(
            'formStrategy' => $formStrategy->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param         $strategy_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $strategy_id){
        $strategy = $this->getHelper()->getStrategiesRepository()->findOneBy(array(
            'id' => $strategy_id,
        ));

        if(false === $strategy instanceof Strategy){
            throw new \Exception('strategy not found');
        }

        $formStrategy = $this->createForm(new StrategyType(),$strategy);
        $formStrategy->handleRequest($request);
        if($formStrategy->isSubmitted() && $formStrategy->isValid()){
            $em = $this->getHelper()->getEntityManager();
            $strat = $formStrategy->getData();
            $em->persist($strat);
            $em->flush();

            return $this->redirectToRoute('dr_strategy_show', array(
                'strategy_id' => $strategy->getId(),
            ));
        }

        return $this->render('WebBundle:Strategy:edit.html.twig', array(
            'strategy' => $strategy,
            'formStrategy' => $formStrategy->createView(),
        ));
    }

    /**
     * @return BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }
}
