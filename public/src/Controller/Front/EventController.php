<?php

namespace App\Controller\Front;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Entity\Entrant;
use App\Service\ModulesHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 * @package App\Controller\Front
 * @Route("/event", name="front_event_")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findBy(
            [
                'deleted' => false,
                'active'  => true
            ]
        );
        return $this->render(
            'front/event/index.html.twig',
            [
                'events' => $events,
            ]
        );
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function newStep1(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('front_event_inscription_entrants', ['slug' => $event->getSlug()]);
        }

        return $this->render('front/event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'step' => 1
        ]);
    }

    /**
     * @param Request $request
     * @param Event $event
     * @Route("/new/entrantRegister/{slug}", name="register_entrant")
     */
    public function registerEntrant(Request $request, Event $event)
    {
        $entrant = new Entrant();
        $user = $this->getUser();

        $entrant->setUserRelated($user);
        $entrant->setPseudo($user->getPseudo());
        $entrant->setEvent($event);
        $entrant->setSlug($event->getSlug());
        $this->addFlash('success', 'Inscription Réussie');

        $em = $this->getDoctrine()->getManager();
        $em->persist($entrant);
        $em->flush();

        return $this->redirectToRoute('front_event_show', ['slug' => $event->getSlug()]);
    }

    /**
     * @Route("/delete/{slug}", name="delete_registered_entrant")
     */
    public function deleteRegisteredEntrant(Request $request, Event $event): Response
    {
        $user = $this->getUser()->getId();
        $entrant = $this->getDoctrine()->getRepository('App:Entrant')->findOneBy(array('user_related' => $user));

        $entityManager = $this->getDoctrine()->getManager();
        $entrant->setDeleted(1);
        $entityManager->flush();

        return $this->redirectToRoute('front_event_show', ['slug' => $event->getSlug()]);
    }

    /**
     * @param Request $request
     * @param Event $event
     * @Route("/new/inscription/{slug}", name="inscription_entrants")
     */
    public function newStep2(Request $request, Event $event)
    {
        $form = $this->createForm(EventType::class, $event, ['entrants' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('front_event_inscription_entrants', ['slug' => $event->getSlug()]);
        }
        return $this->render('front/event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'step' => 2
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Event $event, EventRepository $eventRepository): Response
    {
        if($this->getUser()){
            $user = $this->getUser()->getId();
            $entrants = $eventRepository->findUserRegistered($event, $user);
            return $this->render('front/event/show.html.twig', [
                'event' => $event,
                'user' => $user,
                'entrants' => $entrants
            ]);
        }
        return $this->render('front/event/show.html.twig', ['event' => $event]);
    }
    /**
     * @Route("/{slug}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('front_event_index', ['slug' => $event->getSlug()]);
        }
        return $this->render('front/event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
            'step' => 1
        ]);
    }

    /**
     * @Route("/{slug}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $event->setDeleted(1);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front_event_index');
    }
}
