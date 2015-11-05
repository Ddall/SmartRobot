<?php

namespace Dr\MarketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TradingPairType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Display name',
                'required' => true,
            ))
            ->add('active', 'choice', array(
                'label' => 'Active',
                'choices' => array(
                    0 => 'Inactive', 1 => 'Active'
                ),
            ))
            ->add('submit', 'submit', array(
                'attr' => array(
                    'class' => 'save'
                ),
            ))
        ;

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dr\MarketBundle\Entity\TradingPair'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dr_marketbundle_tradingpair';
    }
}
