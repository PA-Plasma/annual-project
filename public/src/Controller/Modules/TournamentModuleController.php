<?php

namespace App\Controller\Modules;

use App\Controller\Interfaces\ModuleInterface;
use App\Entity\Event;
use App\Entity\Modules\ModuleTournamentParameters;
use App\Form\ModuleTournamentParametersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TournoiModuleController
 * @package App\Controller\Modules
 */
Class TournamentModuleController extends AbstractController implements ModuleInterface
{
    /**
     * @param Event $event
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/event/{slug}/tounament-parameters", name="module_tournament_new", methods={"GET","POST"})
     */
    public function new(Event $event, Request $request)
    {
        $moduleTournoi = $event->getModuleTournament();
        if ($moduleTournoi->getModuleTournamentParameters() !== null) {
            $moduleTournoiParameters = $moduleTournoi->getModuleTournamentParameters();
        } else {
            $moduleTournoiParameters = new ModuleTournamentParameters();
            $moduleTournoiParameters->setModuleTournament($moduleTournoi);
        }

        $form = $this->createForm(ModuleTournamentParametersType::class, $moduleTournoiParameters, [
            'action' => $this->generateUrl('module_tournament_new', ['slug' => $event->getSlug()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($moduleTournoiParameters);
            $entityManager->flush();
            return $this->redirectToRoute('front_event_show', ['slug' => $event->getSlug()]);
        }

        return $this->render('Modules/ModuleTournament/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'moduleTournoi' => $moduleTournoi,
            'name' => 'Tournament'
        ]);
    }

    /**
     * @param Event $event
     * @param Request $request
     */
    public function edit(Event $event, Request $request)
    {
        // TODO: Implement edit() method.
    }

    /**
     * @param Event $event
     * @param Request $request
     * @Route(name="module_tournament_show", path="/event/{slug}/tournament-show")
     */
    public function display(Event $event, Request $request)
    {
        return $this->render("Modules/ModuleTournament/show.html.twig", ['event' => $event]);
    }


}