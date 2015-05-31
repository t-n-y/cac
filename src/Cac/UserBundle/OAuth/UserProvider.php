<?php

namespace Cac\UserBundle\OAuth;

use FOS\UserBundle\Model\UserInterface as FOSUserInterface;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;

use Cac\UserBundle\Entity\User;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * Loading and ad-hoc creation of a user by an OAuth sign-in provider account.
 *
 * @author Fabian Kiss <fabian.kiss@ymc.ch>
 */
class UserProvider extends FOSUBUserProvider
{
    protected $userManager;
    protected $properties;
    protected $discriminator;
    protected $container;

    public function __construct(\FOS\UserBundle\Model\UserManagerInterface $userManager, array $properties, \PUGX\MultiUserBundle\Model\UserDiscriminator $discriminator, Container $container)
    {
        $this->userManager = $userManager;
        $this->properties = $properties;
        $this->discriminator = $discriminator;
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        try {
            return parent::loadUserByOAuthUserResponse($response);
        } catch (UsernameNotFoundException $e) {
            if (null === $user = $this->userManager->findUserByEmail($response->getEmail())) {
                return $this->createUserByOAuthUserResponse($response);
            }

            return $this->updateUserByOAuthUserResponse($user, $response);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $providerName = $response->getResourceOwner()->getName();
        $uniqueId = $response->getUsername();
        $user->addOAuthAccount($providerName, $uniqueId);

        $this->userManager->updateUser($user);
    }

    /**
     * Ad-hoc creation of user
     *
     * @param UserResponseInterface $response
     *
     * @return User
     */
    protected function createUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $this->discriminator->setClass('Cac\UserBundle\Entity\BasicUser');
        $user = $this->userManager->createUser();
        $this->updateUserByOAuthUserResponse($user, $response);
        $em = $this->container->get('doctrine')->getManager();

        $tmpUser = $em->getRepository('Cac\UserBundle\Entity\User')->findOneByEmail($response->getEmail());
        if($tmpUser !== null) {
            $basicUser = $em->getRepository('Cac\UserBundle\Entity\BasicUser')->findOneById($tmpUser->getId());
            $bigboss = $em->getRepository('Cac\UserBundle\Entity\Bigboss')->findOneById($tmpUser->getId());
        }

        var_dump($tmpUser);
        die;

        // set default values taken from OAuth sign-in provider account
        if (null !== $email = $response->getEmail()) {
            if(null !== $basicUser || null !== $bigboss) {
                if(null !== $basicUser) {
                    $user->setFacebookId($response->getId());
                    $logUser = $basicUser;
                } else {
                    $logUser = $bigboss;
                }

                $logToken = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($logUser, null, "main", array("ROLE_USER"));
                $this->get('security.context')->setToken($logToken);

                $event = new \Symfony\Component\Security\Http\Event\InteractiveLoginEvent($this->getRequest(), $logToken);
                $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

                var_dump('hey');
                die;
                return $this->redirect($this->generateUrl('home'));
            } else {
                $user->setEmail($email);
            }
        }

        if (null === $this->userManager->findUserByUsername($response->getNickname())) {
            $user->setUsername($response->getNickname());
        }

        $user->setEnabled(true);

        return $user;
    }

    /**
     * Attach OAuth sign-in provider account to existing user
     *
     * @param FOSUserInterface      $user
     * @param UserResponseInterface $response
     *
     * @return FOSUserInterface
     */
    protected function updateUserByOAuthUserResponse(FOSUserInterface $user, UserResponseInterface $response)
    {
        $providerName = $response->getResourceOwner()->getName();
        $providerNameSetter = 'set'.ucfirst($providerName).'Id';
        $user->$providerNameSetter($response->getUsername());

        if(!$user->getPassword()) {
            // generate unique token
            $secret = md5(uniqid(rand(), true));
            $user->setPassword($secret);
        }

        return $user;
    }
}