<?php

namespace Cac\BarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Cac\BarBundle\Entity\Bar;
use Cac\BarBundle\Entity\Comment;
use Cac\BarBundle\Entity\Promotion;
use Cac\BarBundle\Entity\Image;
use Cac\BarBundle\Form\Type\BarType;
use Cac\BarBundle\Form\Type\PromotionType;
use Cac\BarBundle\Form\Type\BarEditType;
use Cac\BarBundle\Entity\PromoOffertes;
/**
 * Bar controller.
 *
 * @Route("/bars")
 */
class BarController extends Controller
{
    /**
     * @Route("/list", name="bars")
     * @Template()
     */
    public function indexAction()
    {
        setlocale(LC_TIME, "fr_FR");
        $today = strftime("%A");
        
        $em = $this->getDoctrine()->getManager();
    
        $entities = $em->getRepository('CacBarBundle:Bar')->findAll();
        $highlight = $em->getRepository('CacBarBundle:highlight')->findAll();
        shuffle($highlight);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1)/*page number*/,
            16/*limit per page*/
        );
        return array(
            'bars' => $pagination,
            'highlight' => $highlight,
            'today' => $today,
        );    
    }

    /**
     * Finds and displays a Bar entity.
     *
     * @Route("/{id}", name="bar_show", options={"expose"=true})
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function showAction($id)
    {
        setlocale(LC_TIME, "fr_FR");
        $today = strftime("%A");

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);
        $user = $this->get('security.context')->getToken()->getUser();

        $entity->setScore($entity->getScore() +1);
        $em->persist($entity);
        $em->flush();

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'user' => $user,
            'bar'      => $entity,
            'today' => $today,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Bar entity.
    *
    * @param Bar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Bar $entity)
    {
        $form = $this->createForm(new BarEditType(), $entity, array(
            'action' => $this->generateUrl('bar_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));


        $form->add('submit', 
            'submit', 
            array(
                'label' => 'Mettre à jour'
            )
        )
         ->add('file', null, array('label' => 'Modifier la photo'));

        return $form;
    }

    /**
     * Creates a form to delete a Bar entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bar_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 
                'submit', 
                array(
                    'label' => 'Supprimer'
                )
            )
            ->getForm()
        ;
    }
    
    /**
     * @Route("/note/{id}/{text}/{note}", name="bar_eval", options={"expose"=true})
     * @Template()
     */
    public function evalAction($id, $text, $note)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

        $comment = new Comment();
        $comment->setBar($entity);
        $comment->setComment($text);
        $comment->setNote($note);
        $comment->setCreatedAt(new \DateTime('now'));
        $em->persist($comment);
        $em->flush();

        return new Response('comment');
    }

    /**
     * @Route("/get-my-promotion/{id}", name="get_promo", options={"expose"=true})
     */
    public function getMyPromotionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $bar = $em->getRepository('CacBarBundle:Bar')->find($id);
        $user = $this->get('security.context')->getToken()->getUser();
        if ($user !== "anon.") {
            $message = \Swift_Message::newInstance()
                ->setSubject('Hello Email')
                ->setFrom('send@example.com')
                ->setTo('g.leclercq12@gmail.com')
                ->setBody('promo activée, vous avez jusque a ce soir pour aller blba lbla')
            ;
            $this->get('mailer')->send($message);

            $reference = mt_rand(100000,999999);
            $verre = new PromoOffertes();
            $verre->setReference($reference);
            $verre->setEtat('confirmé');
            $verre->setBar($bar);
            $verre->setUser($user);
            $verre->setCreatedAt(new \DateTime('now'));
            $em->persist($verre);
            $em->flush();

            return new Response('get glass');
        }
        else{
            return new Response('user not connected');
        }
    }

}
