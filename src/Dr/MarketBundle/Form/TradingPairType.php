<?php

namespace Dr\MarketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('assetFrom', 'entity', array(
                'label' => 'Asset From',
                'class' => 'DrMarketBundle:Asset',
            ))
            ->add('assetTo', 'entity', array(
                'label' => 'Asset to',
                'class' => 'DrMarketBundle:Asset',
            ))
            ->add('submit', 'submit', array(
                'attr' => array(
                    'class' => 'save'
                ),
            ))
        ;

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
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
