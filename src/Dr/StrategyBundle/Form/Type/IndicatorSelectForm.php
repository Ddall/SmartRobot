<?php
/**
 * DdxSr - IndicatorSelectForm.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Form\Type;

use Dr\StrategyBundle\Service\FilterService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class IndicatorSelectForm extends AbstractType{

    /**
     * @var FilterService
     */
    private $filterService;

    public function __construct(FilterService $filterService) {
        $this->filterService = $filterService;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('filter', ChoiceType::class, array(
                'required' => true,
                'choices' => $this->filterService->getFiltersList()
            ))
            ->add('submit', 'submit', array(
                'attr' => array(
                    'class' => 'save'
                )
            ))

        ;
    }


    /**
     * @return string
     */
    public function getName() {
        return 'dr_strategybundle_indicator_select';
    }
}
