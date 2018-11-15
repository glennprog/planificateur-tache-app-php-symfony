<?php

namespace AppBundle\Controller\Systeme_Information;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class SystemeInformationController extends AbstractController
{
    /**
     * @Route("/system-information", name="system_information")
     */
    public function systemInformationAction(Request $request)
    {
        return $this->render('system-information/system-information.html.twig');
    }
}