<?php

namespace App\Controller\Back;

use App\Entity\Entrant;
use App\Form\EntrantType;
use App\Repository\EntrantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/back/entrant")
 */
class EntrantController extends AbstractController
{
    /**
     * @Route("/", name="entrant_index", methods={"GET"})
     */
    public function index(EntrantRepository $entrantRepository): Response
    {
        return $this->render('entrant/index.html.twig', ['entrants' => $entrantRepository->findAll()]);
    }

    /**
     * @Route("/new", name="entrant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entrant = new Entrant();
        $form = $this->createForm(EntrantType::class, $entrant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entrant);
            $entityManager->flush();

            return $this->redirectToRoute('entrant_index');
        }

        return $this->render('entrant/new.html.twig', [
            'entrant' => $entrant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entrant_show", methods={"GET"})
     */
    public function show(Entrant $entrant): Response
    {
        return $this->render('entrant/show.html.twig', ['entrant' => $entrant]);
    }

    /**
     * @Route("/{id}/edit", name="entrant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entrant $entrant): Response
    {
        $form = $this->createForm(EntrantType::class, $entrant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entrant_index', ['id' => $entrant->getId()]);
        }

        return $this->render('entrant/edit.html.twig', [
            'entrant' => $entrant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entrant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entrant $entrant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entrant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entrant_index');
    }
}