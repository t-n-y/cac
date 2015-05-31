<?php

namespace Cac\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BigbossFormType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', 'repeated', array(
                'label' => 'Mot de passe',
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmez votre mot de passe'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('email', 'repeated', array(
                    'type' => 'email',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'E-mail'),
                    'second_options' => array('label' => 'Confirmez votre e-mail'),
                    'invalid_message' => 'fos_user.email.mismatch',
            ))
            ->add('name', null, array('label' => 'Nom'))
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('gender', 'choice', array(
                'label' => 'Genre',
                'choices'   => array('1' => 'Mr', '2' => 'Mme'),
                'multiple' => false
                )
            )
            ->add('company', null, array('label' => 'Société'))
            ->add('siret', null, array('label' => 'Numéro SIRET','required' => false))
            ->add('fix_phone', 'text', array('label' => 'Téléphone fixe','required' => false))
            ->add('mobile_phone', 'text', array('label' => 'Téléphone mobile'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'registration',
        ));
    }

    public function getName()
    {
        return 'cac_bigboss_registration';
    }
}
