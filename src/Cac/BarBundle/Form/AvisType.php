<?php

namespace Cac\BarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AvisType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', 'text', array(
                'attr' => array(
                    'placeholder' => 'Soyer constructif, bref, objectif',
                )))
            ->add('score', 'hidden', array())
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cac\BarBundle\Entity\Avis'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cac_barbundle_avis';
    }
}
