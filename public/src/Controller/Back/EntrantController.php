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
 * Class EntrantController
 *
 * @category  Class
 * @package   App\Controller\Back
 * @Route("/back/entrant", name="back_entrant_")
 */
class EntrantController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(EntrantRepository $entrantRepository): Response
    {
        $entrnants = $entrantRepository->findBy(
            [
                'deleted' => false
            ]
        );

        return $this->render(
            'back/entrant/index.html.twig',
            [
                'entrants' => $entrnants
            ]
        );
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
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

            return $this->redirectToRoute('back_entrant_index');
        }

        return $this->render('back/entrant/new.html.twig', [
            'entrant' => $entrant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Entrant $entrant): Response
    {
        return $this->render('back/entrant/show.html.twig', ['entrant' => $entrant]);
    }

    /**
     * @Route("/{slug}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entrant $entrant): Response
    {
        $form = $this->createForm(EntrantType::class, $entrant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_entrant_index', ['slug' => $entrant->getSlug()]);
        }

        return $this->render('back/entrant/edit.html.twig', [
            'entrant' => $entrant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entrant $entrant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrant->getSlug(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entrant->setDeleted(1);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_entrant_index');
    }
}
