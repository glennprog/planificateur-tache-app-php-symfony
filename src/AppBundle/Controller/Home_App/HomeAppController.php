<?php

namespace AppBundle\Controller\Home_App;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeAppController extends AbstractController
{
    /**
     * @Route("/", name="home_app")
     */
    public function homeAppAction(Request $request)
    {
        return $this->render('home-app/homeApp.html.twig');
    }
}