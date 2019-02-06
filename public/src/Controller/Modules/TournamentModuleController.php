<?php

namespace App\Controller\Modules;

use App\Controller\Interfaces\ModuleInterface;
use App\Entity\Event;
use App\Entity\Modules\ModuleTournamentParameters;
use App\Form\ModuleTournamentParametersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TournoiModuleController
 * @package App\Controller\Modules
 */
Class TournamentModuleController extends AbstractController implements ModuleInterface
{
    public function new(Event $event, Request $request)
    {
        $moduleTournoi = $event->getModuleTournament();
        $moduleTournoiParameters = new ModuleTournamentParameters();
        $moduleTournoiParameters->setModuleTournament($moduleTournoi);

        $form = $this->createForm(ModuleTournamentParametersType::class, $moduleTournoiParameters);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($moduleTournoiParameters);
            $entityManager->flush();
//            return $this->redirectToRoute('front_event_inscription_entrants', ['slug' => $event->getSlug()]);
        }

        return $this->render('Modules/ModuleTournament/index.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'moduleTournoi' => $moduleTournoi,
            'name' => 'Tournament'
        ]);
    }

    public function edit(Event $event, Request $request)
    {
        // TODO: Implement edit() method.
    }

    public function display($module, Request $request)
    {
        // TODO: Implement display() method.
    }


}