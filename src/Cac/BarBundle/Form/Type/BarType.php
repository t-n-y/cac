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
            ->add('region', null, array('label' => 'Région'))
            ->add('country', null, array('label' => 'Pays'))
            ->add('schedule', 'hidden', array('label' => 'Horaires'))
            ->add('access', 'choice', array(
                'label' => 'Accès',
                'choices'   => array('1' => 'Metro', '2' => 'RER'),
                'required'  => false,
                )
            )
            ->add('beerPrice', null, array(
                'label' => 'La pinte de bière',
                'required'  => false,
                )
            )
            ->add('softPrice', null, array(
                'label' => 'Le soft'
                )
            )
            ->add('coffeePrice', null, array(
                'label' => 'Le café'
                )
            )
            ->add('cocktailPrice', null, array(
                'label' => 'Le cocktail'
                )
            )
            ->add('dressCode', 'choice', array(
                'label' => 'Dresscode',
                'choices'   => array('1' => 'Chic', '2' => 'Casual'),
                'required'  => false,
                )
            )
            ->add('valet', null, array('label' => 'Voiturier', 'required'  => false))
            ->add('valetCost', 'text', array('label' => 'Prix', 'required'  => false))
            ->add('handicappedAccess', null, array('label' => 'Accès handicapés', 'required'  => false))
            ->add('patio', null, array('label' => 'Terrasse', 'required'  => false))
            ->add('smokingArea', null, array('label' => 'Espace fumeurs', 'required'  => false))
            ->add('breathalyser', null, array('label' => 'Ethylotest gratuits', 'required'  => false))
            ->add('babyfoot', null, array('label' => 'Baby Foot', 'required'  => false))
            ->add('billard', null, array('label' => 'Billard', 'required'  => false))
            ->add('flipper', null, array('label' => 'Flipper', 'required'  => false))
            ->add('canape', null, array('label' => 'Canapé', 'required'  => false))
            ->add('clim', null, array('label' => 'Climatisation', 'required'  => false))
            ->add('description', null, array('label' => 'Description', 'required'  => false))
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
