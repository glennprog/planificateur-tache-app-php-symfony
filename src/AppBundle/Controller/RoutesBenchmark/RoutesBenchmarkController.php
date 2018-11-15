<?php

namespace AppBundle\Controller\RoutesBenchmark;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RoutesBenchmarkController extends AbstractController
{
    /**
     * @Route("/routes-benchmark", name="routes_benchmark")
     */
    public function routesBenchmarkAction(Request $request)
    {
        $routes = $this->container->get('router')->getRouteCollection()->all();
        return $this->render('routes-benchmark\routes-benchmark.html.twig', array('routes'=>$routes));
    }
}