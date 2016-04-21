<?php

namespace Cac\BarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brief', null, array('label' => 'Texte bandeau (15 caractères)', 'required'  => true))
            ->add('description', null, array('label' => 'Description', 'required'  => true))
            ->add('startAt', null, array('label' => 'Début de l\'évènement', 'required'  => false))
            ->add('endAt', null, array('label' => 'Fin de l\'évènement', 'required'  => false))
            ->add('displayStartAt', null, array('label' => 'Début de l\'affichage', 'required'  => false))
            ->add('displayEndAt', null, array('label' => 'Fin de l\'affichage', 'required'  => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cac\BarBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cac_barbundle_event';
    }
}
