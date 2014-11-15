<?php

namespace Cac\BarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BarType extends AbstractType
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
            ->add('country', null, array('label' => 'Pays'))
            ->add('schedule', null, array('label' => 'Horaires'))
            ->add('access', 'choice', array(
                'label' => 'Accès',
                'choices'   => array('1' => 'Exemple 1', '2' => 'Exemple 2'),
                'required'  => false,
                )
            )
            ->add('categories', null, array('label' => 'Catégories'))
            ->add('priceRange', 'choice', array(
                'label' => 'Ordre de prix',
                'choices'   => array('1' => 'Pas cher', '2' => 'Pas trop cher', '3' => 'Un peu cher', '4' => 'Cher'),
                'required'  => false,
                )
            )
            ->add('dressCode', 'choice', array(
                'label' => 'Dresscode',
                'choices'   => array('1' => 'Chic', '2' => 'Casual'),
                'required'  => false,
                )
            )
            ->add('valet', null, array('label' => 'Voiturier'))
            ->add('valetCost', 'text', array('label' => 'Prix'))
            ->add('handicappedAccess', null, array('label' => 'Accès handicapés'))
            ->add('patio', null, array('label' => 'Terrasse'))
            ->add('smokingArea', null, array('label' => 'Espace fumeurs'))
            ->add('breathalyser', null, array('label' => 'Alcotests gratuits'))
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
