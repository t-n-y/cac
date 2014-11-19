<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cac\BarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
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
            ->add('username', null, array('label' => 'Nom d\'utilisateur'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmez votre mot de passe'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('email', 'repeated', array(
                    'type' => 'email',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'Courriel'),
                    'second_options' => array('label' => 'Confirmez votre courriel'),
                    'invalid_message' => 'fos_user.email.mismatch',
            ))
            ->add('name', null, array('label' => 'Nom'))
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('firstname', 'choice', array(
                'label' => 'Genre',
                'choices'   => array('1' => 'Homme', '2' => 'Femme', '3' => 'Transgenre (masculin)', '4' => 'Transgenre (feminin)')
                )
            )
            ->add('company', null, array('label' => 'Société'))
            ->add('siret', null, array('label' => 'Numéro SIRET'))
            ->add('fix_phone', 'text', array('label' => 'Téléphone fixe'))
            ->add('mobile_phone', 'text', array('label' => 'Mobile'))
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
        return 'cac_user_registration';
    }
}
