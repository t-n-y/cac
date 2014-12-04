<?php

namespace Cac\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class BarmanFormType extends AbstractType
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
        $id = 5;
        $builder
            ->add('username', null, array('label' => 'Nom d\'utilisateur'))
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
        return 'cac_barman_registration';
    }
}
