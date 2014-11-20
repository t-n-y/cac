<?php

namespace Cac\BarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BarmanType extends AbstractType
{

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cac\BarBundle\Entity\Barman'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cac_barbundle_barman';
    }
}
