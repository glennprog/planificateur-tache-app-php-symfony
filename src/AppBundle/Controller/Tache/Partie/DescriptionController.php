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
class DescriptionController extends AbstractController
{
    /**
     * Consulter Tache Description Action
     * @Route("/description/", name="consulter_tache_description")
     * @Method({"GET", "POST"})
     * 
     */
    public function consulterTacheDescriptionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = array('id' => $id);
        $tache = $em->getRepository('AppBundle:Tache\Tache')->consulterTacheDescription($criteria);
        if (!$tache)
        {
            $donneesTrouveeDrapeau = false;
        }
        else
        {
            $donneesTrouveeDrapeau = true;
        }
        $reponseControle = $this->reponseControle($donneesTrouveeDrapeau, $tache);
        return $this->render('/tache/consulter-tache-partie/consulter-tache-description.html.twig', array('reponse' => $reponseControle));
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