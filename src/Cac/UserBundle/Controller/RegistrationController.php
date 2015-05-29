<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cac\UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Hip\MandrillBundle\Message;
use Hip\MandrillBundle\Dispatcher;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();

        if (strpos($request->getPathInfo(), "/barman/") !== false) {
            $idUser = $this->container->get('security.context')->getToken()->getUser()->getId();
            if (!$idUser) {
                throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
            }
            $form->add('bar', 'entity', array('class' => 'CacBarBundle:Bar', 'property' => 'name', 'attr' => array('placeholder' => 'Bar'),
                'query_builder' => function (\Cac\BarBundle\Entity\BarRepository $repository) use ($idUser)
                             {
                                 return $repository->createQueryBuilder('b')
                                        ->where('b.author = :id')
                                        ->setParameter(':id', $idUser);
                             }
            ));
        }
              
        $form->setData($user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                if (strpos($request->getPathInfo(), "/barman/") === false) {
                    $md = $this->get('hip_mandrill.dispatcher');

                    $message = new Message();
                    $templateName = 'user-validation';
                    $link = 'http://'.$_SERVER['HTTP_HOST'].$this->generateUrl('user_sconfirm', array(
                        'email' => urlencode($user->getEmail()),
                        'token' => $user->getCustomValidationToken()
                        ));
                    $templateContent = array(
                        array(
                            'name' => 'link',
                            'content' => '<a href="'.$link.'">'.$link.'</a>'
                        )
                    );

                    $message
                        ->addTo($user->getEmail(), $user->getFirstname().' '.$user->getName())
                        ->setSubject('Finalisez votre inscription en 1 clic')
                        ->setTrackOpens(true)
                        ->setTrackClicks(true);

                    $result = $md->send($message, $templateName, $templateContent);

                    $url = $this->generateUrl('confirm_email');
                    if(strpos($request->getPathInfo(), "/bigboss/") !== false) {
                        $this->get('session')->getFlashBag()->add('notice','Un email vous a été envoyé pour confirmer la création de votre compte. Celui-ci ne sera pas actif tant que cette étape ne sera pas terminée.');
                        $url = $this->generateUrl('bar_new');
                    }
                    $response = new RedirectResponse($url);
                    $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
                }
                else
                {
                    $this->get('session')->getFlashBag()->add('notice','Le barman a été créé !');
                    $response = new Response('barman');
                }
            }
            
            return $response;
        }
        if (strpos($request->getPathInfo(), "/barman/") !== false) {
            return $this->render('CacUserBundle:Barman:register.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        elseif (strpos($request->getPathInfo(), "/user/") !== false) {
            return $this->render('CacUserBundle:BasicUser:register.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        else
        {
            return $this->render('CacUserBundle:Registration:register.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * Tell the user to check his email provider
     */
    public function checkEmailAction()
    {
        $email = $this->get('session')->get('fos_user_send_confirmation_email/email');
        $this->get('session')->remove('fos_user_send_confirmation_email/email');
        $user = $this->get('fos_user.user_manager')->findUserByEmail($email);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }

        return $this->render('CacUserBundle:Registration:checkEmail.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function confirmAction(Request $request, $token)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        if ($user->getRoles()[0] === 'ROLE_USER') {
            return $this->render('CacUserBundle:Registration:userConfirmed.html.twig', array(
                'user' => $user,
            ));
        }
        else{
            return $this->render('CacUserBundle:Registration:confirmed.html.twig', array(
                'user' => $user,
            ));
        }
    }
}
