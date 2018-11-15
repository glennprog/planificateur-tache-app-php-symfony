<?php

namespace AppBundle\Controller\Tache;

use AppBundle\Entity\Tache\Tache;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * Tache controller
 * 
 * @Route("mes-taches")
 */
class TacheController extends AbstractController
{
    /**
     * Nouvelle Tache Action
     * Create of CRUD
     * 
     * @Route("/nouvelle-tache", name="nouvelle_tache")
     * @Method({"GET", "POST"})
     */
    public function nouvelleTacheAction(Request $request)
    {
        $tache = new Tache;
        $form = $this->createForm('AppBundle\Form\Tache\TacheType', $tache);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        { 
            $em = $this->getDoctrine()->getManager();
            $em->persist($tache);
            $em->flush();
            return $this->redirectToRoute('consulter_tache', array('id' => $tache->getId()));
        }
        return $this->render('tache/nouvelle-tache.html.twig', array('form' => $form->createView(),'tache' => $tache));
    }

    /**
     * Consulter Tache Action
     * Read of CRUD
     * 
     * @Route("/consulter/tache/{id}", name="consulter_tache")
     * @Method("GET")
     */
    public function consulterTacheAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('id' => $id);
        $tache = $em->getRepository('AppBundle:Tache\Tache')->findOneBy($criteria);
        if (!$tache)
        {
            $donneesTrouveeDrapeau = false;
        }
        else
        {
            $donneesTrouveeDrapeau = true;
        }
        $reponseControle = $this->reponseControle($donneesTrouveeDrapeau, $tache);
        return $this->render('/tache/consulter-tache.html.twig', array('reponse' => $reponseControle));
    }

    /**
     * Consulter Tache Action
     * Read of CRUD
     * 
     * @Route("/", name="consulter_liste_taches")
     * @Method("GET")
     */
    public function consulterListeTachesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $liste_taches = $em->getRepository('AppBundle:Tache\Tache')->findAll();
        if (!$liste_taches)
        {
            $donneesTrouveeDrapeau = false;
        }
        else
        {
            $donneesTrouveeDrapeau = true;
        }
        $reponseControle = $this->reponseControle($donneesTrouveeDrapeau, $liste_taches);
        return $this->render('/tache/consulter-liste-taches.html.twig', array('liste_taches' => $liste_taches,'reponse' => $reponseControle));
    }

    /**
     * Modifier Tache Action
     * Update of CRUD
     * 
     * @Route("/modifier/tache/{id}", name="modifier_tache")
     * @Method({"GET", "POST"})
     */

    public function modifierTacheAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('id'=>$id);
        $tache = $em->getRepository('AppBundle:Tache\Tache')->findOneBy($criteria);
        if (!$tache || $tache == null)
        {
            $donneesTrouveeDrapeau = false;
            $reponseControle = $this->reponseControle($donneesTrouveeDrapeau, $tache);
            $reponseControle['edit_form'] = null;
        }
        else
        {
            $donneesTrouveeDrapeau = true;
            $reponseControle = $this->reponseControle($donneesTrouveeDrapeau, $tache);
            $form = $this->createForm('AppBundle\Form\Tache\TacheType', $tache);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $tache->setDateMiseAJour(new \DateTime("now"));
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('consulter_tache', array('id' => $tache->getId()));
            }
            $reponseControle['edit_form'] = $form->createView();
        }
        return $this->render('tache/modifier-tache.html.twig', array('reponse' => $reponseControle));
    }

    /**
     * Supprimer Tache
     * Delete of CRUD
     * 
     * @Route("/supprimer-tache/{id}", name="supprimer_tache")
     * @Method({"GET", "POST", "DELETE"})
     */
    public function supprimerTacheAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('id'=>$id);
        $tache = $em->getRepository('AppBundle:Tache\Tache')->findOneBy($criteria);
        if (!$tache)
        {
            $donneesTrouveeDrapeau = false;
            $request->getSession()->getFlashBag()->add("Danger", "La tache n'existe pas. Rien n'a donc été supprimé.");
        }
        else
        {
            $donneesTrouveeDrapeau = true;
            $em->remove($tache);
            $em->flush();
            $request->getSession()->getFlashBag()->add("success", "La tache a été supprimé.");
        }
        
        return $this->redirectToRoute('consulter_liste_taches');
    }

    public function reponseControle($donneesTrouveeDrapeau, $res)
    {
        if(!$donneesTrouveeDrapeau)
        {
            $codeStatus = 400; // par défaut
            $codeMessage = 400; // par défaut
            $message = 'unsucess'; // par défaut
            $resultat = '{}';
            $reponse =
            [
                'codeStatus'=> $codeStatus,
                'codeMessage'=>$codeMessage,
                'resultat'=>$resultat,
                'message'=>$message,
            ];
        }
        else
        {
            $codeStatus = 200; // par défaut
            $codeMessage = 200; // par défaut
            $message = 'success'; // par défaut
            $resultat = $res;
            $reponse =
            [
                'codeStatus'=> $codeStatus,
                'codeMessage'=>$codeMessage,
                'resultat'=>$resultat,
                'message'=>$message,
            ];
        }
        return $reponse;
    }
}