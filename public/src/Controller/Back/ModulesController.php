<?php

namespace App\Controller\Back;

use App\Entity\Modules;
use App\Form\ModulesType;
use App\Repository\ModulesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 *
 * @category  Class
 * @package   App\Controller\Back
 * @Route("/back/modules", name="back_modules_")
 */
class ModulesController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ModulesRepository $modulesRepository): Response
    {
        $modules = $modulesRepository->findBy(
            [
                'deleted' => false
            ]
        );

        return $this->render(
            'back/modules/index.html.twig',
            [
                'modules' => $modules,
            ]
        );
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $module = new Modules();
        $form = $this->createForm(ModulesType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute('back_modules_index');
        }

        return $this->render('back/modules/new.html.twig', [
            'module' => $module,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="show", methods={"GET"})
     */
    public function show(Modules $module): Response
    {
        return $this->render('back/modules/show.html.twig', ['module' => $module]);
    }

    /**
     * @Route("/{slug}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Modules $module): Response
    {
        $form = $this->createForm(ModulesType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_modules_index', ['slug' => $module->getSlug()]);
        }

        return $this->render('back/modules/edit.html.twig', [
            'module' => $module,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Modules $module): Response
    {
        if ($this->isCsrfTokenValid('delete'.$module->getSlug(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $module->setDeleted(1);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_modules_index');
    }
}
