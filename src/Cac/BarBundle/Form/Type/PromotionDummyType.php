<?php

namespace Cac\BarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PromotionDummyType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('promotion', 'hidden', array('label' => 'Promotion'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cac\BarBundle\Entity\PromotionDummy'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cac_barbundle_promotion_dummy';
    }
}
