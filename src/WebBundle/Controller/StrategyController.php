<?php
/**
 * DdxSr - StrategyController.php
 * Created by Allan.
 */

namespace WebBundle\Controller;


use AppBundle\Exception\NotFoundException;
use Dr\ReaderBundle\Service\BaseHelper;
use Dr\StrategyBundle\Entity\Indicator;
use Dr\StrategyBundle\Entity\Strategy;
use Dr\StrategyBundle\Filter\FilterInterface;
use Dr\StrategyBundle\Form\Type\IndicatorSelectForm;
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
        $strategy = $this->getStrategyEntity($strategy_id);

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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function removeAction(Request $request, $strategy_id){
        $strategy = $this->getStrategyEntity($strategy_id);

        $em = $this->getHelper()->getEntityManager();
        $em->remove($strategy);
        $em->flush();

        return $this->redirectToRoute('dr_strategy_list');
    }

    /**
     * @param Request $request
     * @param         $strategy_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $strategy_id){
        $strategy = $this->getStrategyEntity($strategy_id);

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
     * @param Request $request
     * @param         $strategy_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addIndicatorAction(Request $request, $strategy_id){
        $strategy = $this->getStrategyEntity($strategy_id);
        $filterFormView = null;
        $selectedFilter = null;

        $indicatorSelectForm = $this->createForm( new IndicatorSelectForm( $this->getHelper()->getFilterService() ));
        $indicatorSelectForm->handleRequest($request);

        if($indicatorSelectForm->isSubmitted() && $indicatorSelectForm->isValid()){

            $data = $indicatorSelectForm->getData();
            $filter_id = $data['filter'];

            $filter = $this->getHelper()->getFilterService()->get($filter_id);
            $selectedFilter = $filter->getName();

            if($filter instanceof FilterInterface){
                $filterForm = $this->getHelper()->getFilterService()->createFormById($filter_id);
                $filterFormView = $filterForm->createView();
            }else{
                throw new NotFoundException('Filter not found');
            }
        }elseif($request->isMethod('post')){
            $data = $request->request->get('form');
            if(array_key_exists('filter_id', $data) && !empty($data['filter_id']) ){

                $filterForm = $this->getHelper()->getFilterService()->createFormById($data['filter_id']);
                $filterForm->handleRequest($request);
                if($filterForm->isSubmitted() && $filterForm->isValid() ){
                    // Create new indicator
                    $indicator = new Indicator();
                    $indicator->setName();


                }

            }

        }

        return $this->render('WebBundle:Strategy:addIndicator.html.twig', array(
            'strategy' => $strategy,
            'indicatorSelectForm' => $indicatorSelectForm->createView(),
            'filterFormView' => $filterFormView,
            'selectedFilter' => $selectedFilter,
        ));
    }

    /**
     * @param $strategy_id
     * @return object
     * @throws \Exception
     */
    protected function getStrategyEntity($strategy_id, $strict = true){
        $strategy = $this->getHelper()->getStrategiesRepository()->findOneBy(array(
            'id' => $strategy_id,
        ));

        if($strict && false === $strategy instanceof Strategy){
            throw new \Exception('Strategy not found');
        }

        return $strategy;
    }

    /**
     * @return BaseHelper
     */
    protected function getHelper(){
        return $this->get('dr.helper');
    }
}
