<?php

namespace App\Controller\Modules;

use App\Controller\Interfaces\ModuleInterface;
use App\Entity\Event;
use App\Entity\Modules\ModuleTeamParameters;
use App\Form\ModuleTeamParametersType;
use App\Form\ModuleTeamType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TournoiModuleController
 * @package App\Controller\Modules
 */
Class TeamModuleController extends AbstractController implements ModuleInterface
{
    /**
     * @param Event $event
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/event/{slug}/team-parameters", name="module_team_parameters", methods={"GET","POST"})
     */
    public function parameters(Event $event, Request $request)
    {
        $moduleTeam = $event->getModuleTeam();
        if ($moduleTeam->getModuleTeamParameters() !== null) {
            $moduleTeamParameters = $moduleTeam->getModuleTeamParameters();
        } else {
            $moduleTeamParameters = new ModuleTeamParameters();
            $moduleTeamParameters->setModuleTeam($moduleTeam);
        }
        $form = $this->createForm(
            ModuleTeamParametersType::class,
            $moduleTeamParameters,
            [
                'action' => $this->generateUrl('module_team_parameters', ['slug' => $event->getSlug()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($moduleTeamParameters);
            $entityManager->flush();

            return $this->redirectToRoute('front_event_show', ['slug' => $event->getSlug()]);
        }

        return $this->render('Modules/ModuleTeam/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'moduleTeam' => $moduleTeam,
            'name' => 'Team',
            'ajax' => (($request->getMethod() === 'GET') ? false : true)
        ]);
    }

    /**
    **
    * @param Event $event
    * @param Request $request
    * @Route(name="module_team_show", path="/event/{slug}/team-show")
    */
    public function display(Event $event, Request $request)
    {
        $moduleTeam = $event->getModuleTeam();
        $formTeam = $this->createForm(ModuleTeamType::class, $moduleTeam);
        $formTeam->handleRequest($request);
        if ($formTeam->isSubmitted() && $formTeam->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($moduleTeam);
            $entityManager->flush();

            return $this->redirectToRoute('module_team_show', ['slug' => $event->getSlug()]);
        }

        return $this->render("Modules/ModuleTeam/show.html.twig", ['event' => $event, 'formTeam' => $formTeam->createView()]);
    }
}
