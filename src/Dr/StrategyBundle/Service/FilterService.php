<?php
/**
 * DdxSr - FilterService.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Service;


use AppBundle\Exception\BaseException;
use AppBundle\Exception\NotFoundException;
use Dr\ReaderBundle\Service\AbstractDdxDrService;
use Dr\StrategyBundle\Filter\AbstractFilter;
use Dr\StrategyBundle\Filter\FilterInterface;
use Dr\StrategyBundle\Filter\FilterParameter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class FilterService extends AbstractDdxDrService{

    /**
     * Stores an array of string with the names of the filters
     * @var array
     */
    private $filters;


    /**
     * @var FormFactory
     */
    private $formFactory;


    /**
     * FilterService constructor.
     *
     * @param array       $filters
     * @param FormFactory $formFactory
     */
    public function __construct(array $filters, FormFactory $formFactory) {
        $this->filters = $filters;
        $this->formFactory = $formFactory;
    }

    /**
     * @return array
     */
    public function getFilters(){
        return $this->filters;
    }


    /**
     * @return array
     * @throws BaseException
     */
    public function getFiltersInstances(){
        $output = array();
        foreach($this->filters as $key => $filter){
            $instance = new $filter;

            if(false === $instance instanceof AbstractFilter){
                throw new BaseException('FilterService::getFiltersInstances: cant create instance of ' . $filter);
            }

            $output[ $instance->getIdentifier() ] = $instance;
        }

        return $output;
    }

    /**
     * @return array
     * @throws BaseException
     */
    public function getFiltersList(){
        $output = $this->getFiltersInstances();

        foreach($output as $key => $filter){
            $output[$key] = $filter->getName();
        }

        return $output;
    }

    /**
     * @param string $filter_id
     * @param bool $strict
     * @return FilterInterface|null
     * @throws BaseException
     */
    public function get($filter_id, $strict = false){
        $filters = $this->getFiltersInstances();

        if(is_string($filter_id) && array_key_exists($filter_id, $filters)){
            return $filters[$filter_id];
        }elseif($strict === true){
            throw new NotFoundException('Filter not found');
        }else{
            return null;
        }
    }


    /**
     * @param $filter_id
     * @return \Symfony\Component\Form\FormBuilderInterface
     * @throws NotFoundException
     */
    public function createFormById($filter_id){
        $filter = $this->get($filter_id, true);
        $filterDefaults = $filter->getDefaults();

        $form = $this->formFactory->createBuilder();
        foreach($filterDefaults as $key => $parameter){
            $formParameters = array();

            // LABEL
            if( $parameter->hasLabel() ){
                $formParameters['label'] = $parameter->getLabel();
            }else{
                $formParameters['label'] = ucwords($key);
            }

            // TYPE
            if($parameter->hasChoices()){
                $type = ChoiceType::class;
                $formParameters['choices'] = $parameter->getChoices();

            }else{

                switch($parameter->getType()){

                    case FilterParameter::TYPE_INTEGER :
                        $type = IntegerType::class;

                    break;

                    case FilterParameter::TYPE_FLOAT:
                        $type = NumberType::class;
                        break;

                    case FilterParameter::TYPE_BOOL:
                        $type = ChoiceType::class;

                        $formParameters['choices'] = array(
                            true => 'True',
                            false => 'False',
                        );

                        break;

                    default:
                        $type = null;
                        break;
                }

            }

            // REQUIRED
            if($parameter->isRequired()){
                $formParameters['required'] = true;
            }else{
                $formParameters['required'] = false;
            }

            // DEFAULT VALUE
            if($parameter->hasDefault()){
                $formParameters['data'] = $parameter->getDefault();
            }

            $form->add($key, $type, $formParameters);
        }

        $form->add('submit', SubmitType::class, array(
           'label' => 'Create',
        ));

        return $form->getForm();
    }

}
