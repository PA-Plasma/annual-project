<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 *
 * @package App\Controller\Back
 * @Route("/back", name="back_")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('back/default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
