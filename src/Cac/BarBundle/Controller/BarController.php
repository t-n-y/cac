<?php

namespace Cac\BarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Cac\BarBundle\Entity\Bar;
use Cac\BarBundle\Entity\Comment;
use Cac\BarBundle\Entity\Promotion;
use Cac\BarBundle\Entity\PromoOffertes;
use Cac\BarBundle\Entity\PromoOffertesRepository;
use Cac\BarBundle\Entity\Image;
use Cac\BarBundle\Form\Type\BarType;
use Cac\BarBundle\Form\Type\PromotionType;
use Cac\BarBundle\Form\Type\BarEditType;
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
        // Mac et UNIX/Linux
        setlocale(LC_TIME, "fr_FR");
        // Windows
        //setlocale(LC_TIME, "french");
        $today = ucfirst(strftime("%A"));
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CacBarBundle:Bar')->findAll();
        $bars = array();
        $i = 0;
        foreach ($entities as $entity) {
            $promoOfTheDay = $entity->getPromotionByDay($today)->getOption('value')->getValue();
            $happyHourOfTheDay = $entity->getHappyHourByDay($today)->getOption('value')->getValue();
            $nbAvis = count($entity->getComments()->getValues());
            $coms = $entity->getComments()->getValues();
            $note = 0;
            foreach ($coms as $com) {
                $note += $com->getNote();
            }
           $bars[$i]['id'] = $entity->getId();
           $bars[$i]['path'] = $entity->getPath();
           $bars[$i]['name'] = $entity->getName();
           $bars[$i]['dresscode'] = $entity->getDressCode();
           $bars[$i]['averagePrice'] = $entity->getCocktailPrice();
           $bars[$i]['adress'] = $entity->getAdress();
           $bars[$i]['zipcode'] = $entity->getZipCode();
           $bars[$i]['town'] = $entity->getTown();
           $bars[$i]['nbAvis'] = $nbAvis;
           $bars[$i]['note'] = $note;
           $bars[$i]['promo'] = $promoOfTheDay;
           $bars[$i]['happy'] = $happyHourOfTheDay;
           $bars[$i]['author'] = $entity->getAuthor();
           $i ++;
        }
        $highlight = $em->getRepository('CacBarBundle:highlight')->findAll();
        shuffle($highlight);

        $highlightBars = array();
        $h = 0;
        foreach ($highlight as $high) {
                $promoOfTheDay = $high->getBar()->getPromotionByDay($today)->getOption('value')->getValue();
                $happyHourOfTheDay = $high->getBar()->getHappyHourByDay($today)->getOption('value')->getValue();
                $nbAvis = count($high->getBar()->getComments()->getValues());
                $coms = $high->getBar()->getComments()->getValues();
                $note = 0;
                foreach ($coms as $com) {
                    $note += $com->getNote();
                }
               $highlightBars[$h]['id'] = $high->getBar()->getId();
               $highlightBars[$h]['path'] = $high->getBar()->getPath();
               $highlightBars[$h]['name'] = $high->getBar()->getName();
               $highlightBars[$h]['dresscode'] = $high->getBar()->getDressCode();
               $highlightBars[$h]['averagePrice'] = $high->getBar()->getCocktailPrice();
               $highlightBars[$h]['adress'] = $high->getBar()->getAdress();
               $highlightBars[$h]['zipcode'] = $high->getBar()->getZipCode();
               $highlightBars[$h]['town'] = $high->getBar()->getTown();
               $highlightBars[$h]['nbAvis'] = $nbAvis;
               $highlightBars[$h]['note'] = $note;
               $highlightBars[$h]['promo'] = $promoOfTheDay;
               $highlightBars[$h]['happy'] = $happyHourOfTheDay;
               $highlightBars[$h]['author'] = $high->getBar()->getAuthor();
               $h ++;
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $bars,
            $this->get('request')->query->get('page', 1)/*page number*/,
            16/*limit per page*/
        );
        return array(
            'bars' => $pagination,
            'highlight' => $highlightBars,
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
        // Mac et UNIX/Linux
        setlocale(LC_TIME, "fr_FR");
        // Windows
        //setlocale(LC_TIME, "french");
        $today = ucfirst(strftime("%A"));

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);
        $sliderImages = $em->getRepository('CacBarBundle:File')->findBy(array('bar' => $entity->getId(), 'slider' => 1));
        $user = $this->get('security.context')->getToken()->getUser();
        $date = date('Y-m-d');
        if($user != 'anon.') {
            $promoOfferte = $em->getRepository('CacBarBundle:PromoOffertes')->getDayPromo($entity->getId(), $user->getId(), $date);
        } else {
            $promoOfferte = false;
        }
        $entity->setScore($entity->getScore() +1);
        $em->persist($entity);
        $em->flush();

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'user' => $user,
            'bar'      => $entity,
            'sliderImages' => $sliderImages,
            'today' => ucfirst($today),
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'promoOfferte' => $promoOfferte,
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
     * @Route("/get-my-promotion/{id}/{value}/{nbPersonne}/{time}", name="get_promo", options={"expose"=true})
     */
    public function getMyPromotionAction($id, $value, $nbPersonne, $time)
    {
        $em = $this->getDoctrine()->getManager();
        $bar = $em->getRepository('CacBarBundle:Bar')->find($id);
        $user = $this->get('security.context')->getToken()->getUser();
        if ($user !== "anon.") {
            $message = \Swift_Message::newInstance()
                ->setSubject('Hello Email')
                ->setFrom('send@example.com')
                ->setTo('g.leclercq12@gmail.com')
                ->setBody('promo activée, vous avez jusque a ce soir pour y aller')
            ;
            $this->get('mailer')->send($message);

            $reference = mt_rand(100000,999999);
            $promo = new PromoOffertes();
            $promo->setReference($reference);
            $promo->setEtat('confirmé');
            $promo->setBar($bar);
            $promo->setValue($value);
            $promo->setNbpersonne($nbPersonne);
            $promo->setHour($time);
            $promo->setUser($user);
            $promo->setCreatedAt(new \DateTime('now'));
            $em->persist($promo);
            $em->flush();

            $customer = $promo->getBar()->getAuthor();
            \Stripe\Stripe::setApiKey("sk_test_zLHsgtijLe1xYM1XPhf12zGY");
            $payment = $em->getRepository('CacPaymentBundle:Payment')->findOneByUser($customer);
            $customerId = $payment->getCustomerId();
            \Stripe\InvoiceItem::create(array(
                "customer" => $customerId,
                "amount" => $customer->getGlassPrice(),
                "currency" => "eur",
                "description" => "Promotion")
            );

            return new Response('get glass');
        }
        else{
            return new Response('user not connected');
        }
    }
}
