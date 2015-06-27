<?php

namespace Cac\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\UserBundle\Entity\Barman;
use Cac\UserBundle\Form\RegistrationBarmanFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Barman controller.
 *
 * @Route("/barman")
 */
class BarmanController extends Controller
{
    /**
     * Register new Barman entities.
     *
     * @Route("/register", name="barman_register")
     * @Template()
     */
    public function registerAction()
    {
        return $this->container
                    ->get('pugx_multi_user.registration_manager')
                    ->register('Cac\UserBundle\Entity\Barman');
    }

    /**
     * list all barmans.
     *
     * @Route("/list/{idBigboss}", name="barman_list")
     * @Template()
     */
    public function barmanListAction($idBigboss)
    {
        $em = $this->getDoctrine()->getManager();
        $bars = $em->getRepository("CacBarBundle:Bar")->findByAuthor($idBigboss);  
        $barmans = array();
        foreach ($bars as $bar) {
            $nbBarman = count($bar->getBarman()->getValues());
            for ($i=0; $i < $nbBarman ; $i++) { 
                $barmans[] = $bar->getBarman()->getValues()[$i];
            }
        }    
        return array('barmans' => $barmans);
    }

    /**
     * delete barman.
     *
     * @Route("/delete/{id}", name="barman_delete", options={"expose"=true})
     * @Template()
     */
    public function barmanDeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $barman = $em->getReference('Cac\UserBundle\Entity\Barman', $id);
        if ($barman->getBar()->getAuthor() !== $this->get('security.context')->getToken()->getUser()) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à effectuer cette action.');
        }
        $em->remove($barman);
        $em->flush();
        return new Response("Barman supprimé");
    }
}
