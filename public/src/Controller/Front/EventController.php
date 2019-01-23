<?php

namespace App\Controller\Front;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
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
                'deleted' => false
            ]
        );

        return $this->render(
            'front/event/index.html.twig',
            [
                'events' => $events
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
     * @Route("/new/inscription/{slug}", name="inscription_entrants")
     */
    public function newStep2(Request $request, Event $event)
    {
        dump($event);
        $form = $this->createForm(EventType::class, $event, ['entrants' => true]);
        $form->handleRequest($request);
        dump($form);
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
    public function show(Event $event): Response
    {
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
        ]);
    }

    /**
     * @Route("/{slug}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }
        return $this->redirectToRoute('front_event_index');
    }
}
