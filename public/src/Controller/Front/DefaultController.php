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
        return $this->render('front/default/header.html.twig', ['route' => $route]);
    }
}
