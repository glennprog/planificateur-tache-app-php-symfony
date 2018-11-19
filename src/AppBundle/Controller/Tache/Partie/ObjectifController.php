<?php

namespace AppBundle\Controller\Tache\Partie;

use AppBundle\Entity\Tache\Tache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Description controller
 * 
 * @Route("mes-taches/consulter/tache/{id}")
 */
class ObjectifController extends AbstractController
{
    /**
     * Consulter Tache Objectif Action
     * @Route("/objectif/", name="consulter_tache_objectif")
     * @Method({"GET", "POST"})
     * 
     */
    public function consulterTacheObjectifAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('id' => $id);
        $tache = $em->getRepository('AppBundle:Tache\Tache')->consulterTacheObjectif($criteria);
        if (!$tache)
        {
            $donneesTrouveeDrapeau = false;
        }
        else
        {
            $donneesTrouveeDrapeau = true;
        }
        $reponseControle = $this->reponseControle($donneesTrouveeDrapeau, $tache);
        return $this->render('/tache/consulter-tache-partie/consulter-tache-objectif.html.twig', array('reponse' => $reponseControle));
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