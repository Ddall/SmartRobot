<?php

namespace Dr\StrategyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StrategyType extends AbstractType
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
                'attr' => array(
                    'placeholder' => 'Name (required)',
                )
            ))
            ->add('active', 'choice', array(
                'label' => 'Active',
                'required' => false,
                'choices' => array(
                    true => 'Yes',
                    false => 'No',
                )
            ))
            ->add('comment', 'textarea', array(
                'label' => "Comment",
                'required' => false,
                'attr' =>   array(
                    'placeholder' => 'Comment',
                )
            ))
            ->add('submit', 'submit', array(
                'attr' => array(
                    'class' => 'save',
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dr\StrategyBundle\Entity\Strategy'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dr_strategybundle_strategy';
    }
}
