<?php

namespace Cac\BarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PromotionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Nom de l\'établissement'))
            ->add('adress', null, array('label' => 'Adresse'))
            ->add('zipcode', null, array('label' => 'Code Postal'))
            ->add('town', null, array('label' => 'Ville'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cac\BarBundle\Entity\Bar',
            'intention'  => 'registration',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cac_barbundle_bar';
    }
}
