<?php

namespace AppBundle\Controller\Tache;

use AppBundle\Entity\Tache\Tache;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use AppBundle\Service\Serialiseur;


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
     * @Route("/nouvelle-tache-json-full", name="nouvelle_tache_json_full")
     * @Method({"GET", "POST"})
     */
    public function nouvelleTacheAction(Request $request)
    {
        // Cause of I do not want use a specif code to noticed that it is Ajax request : request->isXmlHttpRequest
        if ($request->attributes->get('_route') == "nouvelle_tache_json_full") {

            if ($request->server->get("REQUEST_METHOD") == "POST") {
                $data = json_decode($request->getContent()); // Get parameters sent by POST method.
                if ($data == null) 
                {
                    $reponseControle = $this->reponseControle(false, null, "Les données envoyées ne sont pas correctes.");
                    return new JsonResponse(array('reponseControle' => $reponseControle), 400);    
                } 
                elseif ($request->server->get("CONTENT_TYPE") != "application/json") 
                {
                    $reponseControle = $this->reponseControle(false, null, "Veuillez utiliser le content type application/json.");
                    return new JsonResponse(array('reponseControle' => $reponseControle), 400);    
                } 
                else 
                {
                    $tache = new Tache();
                    $tache->setNom($data->nom);
                    $tache->setDescription($data->nom);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($tache);
                    $em->flush();

                    $serialiseur = new Serialiseur();
                    $tache_json = $serialiseur->encodeur($tache, "json");

                    $donneesTrouveeDrapeau = true;
                    $reponseControle = $this->reponseControle($donneesTrouveeDrapeau, $tache_json, "la tâche a été ajoutée.");
                    return new JsonResponse(array('reponseControle' => $reponseControle), 200);
                }
            } 
            else 
            {
                $reponseControle = $this->reponseControle(false, null, "La mathode utilisé est mauvaise. Veuillez utiliser la méthode POST.");
                return new JsonResponse(array('reponseControle' => $reponseControle), 400);  
            }
        }

        $tache = new Tache;
        $form = $this->createForm('AppBundle\Form\Tache\TacheType', $tache);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tache);
            $em->flush();
            return $this->redirectToRoute('consulter_tache', array('id' => $tache->getId()));
        }
        return $this->render('tache/nouvelle-tache.html.twig', array('form' => $form->createView(), 'tache' => $tache));
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
        if (!$tache) {
            $donneesTrouveeDrapeau = false;
        } else {
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
     * @Route("/globales", name="consulter_liste_taches_globales")
     * @Route("/archivees", name="consulter_liste_taches_archivees")
     * @Route("/non-archivees", name="consulter_liste_taches_non_archivees")
     * @Method("GET")
     */
    public function consulterListeTachesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->attributes->get('_route') == "consulter_liste_taches_archivees") {
            $criteria = array('est_archivee' => true);
        } elseif ($request->attributes->get('_route') == "consulter_liste_taches_non_archivees") {
            $criteria = array('est_archivee' => false);
        } elseif ($request->attributes->get('_route') == "consulter_liste_taches_globales") {
            $criteria = array();
        } else // on récupère toutes les tâches (archivees et non archivees)
        {
            $criteria = array('est_archivee' => false);
        }
        $orderBy = array('statut' => 'ASC', 'ordre' => 'ASC');
        $limit = null;
        $offset = null;
        $liste_taches = $em->getRepository('AppBundle:Tache\Tache')->findBy($criteria, $orderBy, $limit, $offset);

        if (!$liste_taches) {
            $donneesTrouveeDrapeau = false;
        } else {
            $donneesTrouveeDrapeau = true;
        }

        $reponseControle = $this->reponseControle($donneesTrouveeDrapeau, $liste_taches);

        $monitoring_liste_taches_total = $em->getRepository('AppBundle:Tache\Tache')->monitoring_liste_taches_total();

        return $this->render(
            '/tache/consulter-liste-taches.html.twig',
            array('liste_taches' => $liste_taches, 'reponse' => $reponseControle, 'monitoring_liste_taches_total' => $monitoring_liste_taches_total)
        );
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
        $criteria = array('id' => $id);
        $tache = $em->getRepository('AppBundle:Tache\Tache')->findOneBy($criteria);
        if (!$tache || $tache == null) {
            $donneesTrouveeDrapeau = false;
            $reponseControle = $this->reponseControle($donneesTrouveeDrapeau, $tache);
            $reponseControle['edit_form'] = null;
        } else {
            $donneesTrouveeDrapeau = true;
            $reponseControle = $this->reponseControle($donneesTrouveeDrapeau, $tache);
            $form = $this->createForm('AppBundle\Form\Tache\TacheType', $tache);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
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
        $criteria = array('id' => $id);
        $tache = $em->getRepository('AppBundle:Tache\Tache')->findOneBy($criteria);
        if (!$tache) {
            $donneesTrouveeDrapeau = false;
            $request->getSession()->getFlashBag()->add("Danger", "La tache n'existe pas. Rien n'a donc été supprimé.");
        } else {
            $donneesTrouveeDrapeau = true;
            $em->remove($tache);
            $em->flush();
            $request->getSession()->getFlashBag()->add("success", "La tache a été supprimé.");
        }

        return $this->redirectToRoute('consulter_liste_taches');
    }

    /**
     * Archiver Tache
     * 
     * @Route("/archiver-tache/{id}", name="archiver_tache")
     * @Route("/desarchiver-tache/{id}", name="desarchiver_tache")
     * @Method({"GET", "POST", "DELETE"})
     */
    public function archiverDesarchiverTacheAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('id' => $id);
        $tache = $em->getRepository('AppBundle:Tache\Tache')->findOneBy($criteria);
        if (!$tache) {
            $donneesTrouveeDrapeau = false;
            $request->getSession()->getFlashBag()->add("Danger", "La tache n'existe pas. Rien n'a donc été supprimé.");
        } else {
            $donneesTrouveeDrapeau = true;

            if ($request->attributes->get('_route') == "archiver_tache") // Test si on es sur la route pour archiver la tâche
            {
                if ($tache->getEstArchivee()) // Test si la tâche est déjà archivée
                {
                    $request->getSession()->getFlashBag()->add("warning", "La tache est déjà archivée.");
                } else {
                    $tache->setEstArchivee(true);
                    $em->flush();
                    $request->getSession()->getFlashBag()->add("success", "La tache a été archivée.");
                }
            } elseif ($request->attributes->get('_route') == "desarchiver_tache") {
                if (!$tache->getEstArchivee()) // Test si la tâche est déjà désarchivée
                {
                    $request->getSession()->getFlashBag()->add("warning", "La tache est déjà désarchivée.");
                } else {
                    $tache->setEstArchivee(false);
                    $em->flush();
                    $request->getSession()->getFlashBag()->add("success", "La tache a été désarchivée.");
                }
            } else {
                $request->getSession()->getFlashBag()->add("success", "Aucunes actions reconnues sur l'archivage et désarchivage de la tâche.");
            }
        }
        return $this->redirectToRoute('consulter_liste_taches');
    }

    public function reponseControle($donneesTrouveeDrapeau, $res, $message = null)
    {
        if (!$donneesTrouveeDrapeau) {
            $codeStatus = 400; // par défaut
            $codeMessage = 400; // par défaut

            if($message == null)
            {
                $message = 'unsucess'; // par défaut
            }

            $resultat = '{}';
            $reponse =
                [
                'codeStatus' => $codeStatus,
                'codeMessage' => $codeMessage,
                'resultat' => $resultat,
                'message' => $message,
            ];
        } else {
            $codeStatus = 200; // par défaut
            $codeMessage = 200; // par défaut
            if($message == null)
            {
                $message = 'success'; // par défaut
            }
            $resultat = $res;
            $reponse =
                [
                'codeStatus' => $codeStatus,
                'codeMessage' => $codeMessage,
                'resultat' => $resultat,
                'message' => $message,
            ];
        }
        return $reponse;
    }
}