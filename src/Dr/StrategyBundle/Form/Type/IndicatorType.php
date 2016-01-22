<?php

namespace Dr\StrategyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('name', TextType::class, array(
                'label' => 'Name',
                'label_attr' => 'Name for the new indicator',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'Name',
                )
            ))
            ->add('comments', TextareaType::class, array(
                'label' => 'Comments',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Comments ...'
                )
            ))
            ->add('filter', new FormBuilder(), array(

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
