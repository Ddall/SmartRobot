<?php

namespace Dr\MarketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Name',
                'required' => true,
                'attr'  =>  array(
                    'placeholder' => 'Full name (ex: US Dollar, Euro)'
                )
            ))
            ->add('abbr', 'text', array(
                'label' => 'Abbreviation',
                'required' => true,
                'attr'  => array(
                    'placeholder' => 'Abbreviation (ex: USD, EUR)'
                )
            ))
            ->add('symbol', 'text', array(
                'label' =>  'Symbol',
                'required' => false,
                'attr'  => array(
                    'placeholder' => 'Symbol (ex: €, $)'
                )
            ))
            ->add('type', 'choice', array(
                'label' => 'Type',
                'choices' => array(
                    0 => 'Undefined',
                    1 => 'Fiat',
                    2 => 'Virtual',
                ),
            ))
            ->add('submit', 'submit', array(
                'attr' => array(
                    'class' => 'save'
                ),
            ))
        ;
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dr\MarketBundle\Entity\Asset'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dr_marketbundle_asset';
    }
}
