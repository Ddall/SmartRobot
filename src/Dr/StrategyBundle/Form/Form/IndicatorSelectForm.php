<?php
/**
 * DdxSr - IndicatorSelectForm.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Form\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class IndicatorSelectForm extends AbstractType{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('filter', ChoiceType::class, array(
                'required' => true,
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
