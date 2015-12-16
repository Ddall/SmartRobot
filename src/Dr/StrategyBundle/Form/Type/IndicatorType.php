<?php

namespace Dr\StrategyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IndicatorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Name',
                )
            ))
            ->add('filter')
            ->add('parameters')
            ->add('comments')
            ->add('strategy')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dr\StrategyBundle\Entity\Indicator'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dr_strategybundle_indicator';
    }
}
