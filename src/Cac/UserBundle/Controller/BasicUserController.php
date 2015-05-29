<?php

namespace Cac\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\UserBundle\Entity\Bigboss;
use Cac\UserBundle\Form\RegistrationBigbossFormType;
use Hip\MandrillBundle\Message;
use Hip\MandrillBundle\Dispatcher;

/**
 * Barman controller.
 *
 * @Route("/user")
 */
class BasicUserController extends Controller
{
    /**
     * Register new user entities.
     *
     * @Route("/register", name="user_register")
     * @Template()
     */
    public function registerAction()
    {
        return $this->container
                    ->get('pugx_multi_user.registration_manager')
                    ->register('Cac\UserBundle\Entity\BasicUser');
    }

    /**
     * @Route("/confirm-email", name="confirm_email")
     * @Template()
     */
    public function confirmEmailAction()
    {
        return array();
    }

    /**
     * Activate user based on token.
     *
     * @Route("/sconfirm/{email}&{token}", name="user_sconfirm")
     * @Template()
     */
    public function sconfirmAction($email, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('Cac\UserBundle\Entity\BasicUser')->findOneByCustomValidationToken($token);
        if($user === null) return $this->redirect($this->generateUrl('user_resend_validation'));
        $user->setIsActive(true);
        $em->persist($user);
        $em->flush();

        return array(
            'user' => $user
        );
    }

    /**
     * Form to reactivate user.
     *
     * @Route("/resend-validation", name="user_resend_validation")
     * @Template()
     */
    public function resendValidationAction()
    {
        return array();
    }

    /**
     * Resend mail for validation
     *
     * @Route("/resend-email", name="user_resend_email")
     * @Template()
     */
    public function resendEmailAction(Request $request)
    {
        $email = $request->request->get('email');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('Cac\UserBundle\Entity\User')->findOneByEmail($email);
        if($user !== null) $basicUser = $em->getRepository('Cac\UserBundle\Entity\BasicUser')->findOneById($user->getId());
        if($user !== null && $basicUser !== null) {
            $md = $this->get('hip_mandrill.dispatcher');

            $message = new Message();
            $templateName = 'user-validation';
            $link = 'http://'.$_SERVER['HTTP_HOST'].$this->generateUrl('user_sconfirm', array(
                'email' => urlencode($basicUser->getEmail()),
                'token' => $basicUser->getCustomValidationToken()
                ));
            $templateContent = array(
                array(
                    'name' => 'link',
                    'content' => '<a href="'.$link.'">'.$link.'</a>'
                )
            );

            $message
                ->addTo($basicUser->getEmail(), $basicUser->getFirstname().' '.$basicUser->getName())
                ->setSubject('Finalisez votre inscription en 1 clic')
                ->setTrackOpens(true)
                ->setTrackClicks(true);

            $result = $md->send($message, $templateName, $templateContent);
            return $this->redirect($this->generateUrl('confirm_email'));
        }
        return $this->render('CacUserBundle:BasicUser:resendValidation.html.twig', array(
                'email' => $email,
            ));
    }
}