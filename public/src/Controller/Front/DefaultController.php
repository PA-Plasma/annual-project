<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 *
 * @package App\Controller\Front
 * @Route("/", name="front_")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('front/default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * Get header action
     *
     * @param $route
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getHeaderAction($route)
    {
        return $this->render('page/header.html.twig', ['route' => $route]);
    }

    /**
     * Get operations action
     *
     * @param $route
     * @param $entity
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOperationsAction($route, $entity)
    {
        $routeSuffix =  substr($route, 0, strrpos($route, "_"));

        return $this->render('page/operations.html.twig', [
            'route' => $route,
            'routeSuffix' => $routeSuffix,
            'entity' => $entity
        ]);
    }
}
