<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\EntrantRepository;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;


/**
 * Class ProfileController
 *
 * @package App\Controller\Front
 * @Route("front/profile", name="front_")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile")
     */
    public function index(EventRepository $eventRepository, EntrantRepository $entrantRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $user_id = $user->getId();

        $eventOwner = $eventRepository->findBy(
            [
                'createdBy' => $user_id
            ]
        );

        /*$eventEntrant = $entrantRepository->findBy(
            [
                'user_related' => $user_id
            ]
        );*/

        return $this->render('front/profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
            'events_owned' => $eventOwner,
           // 'events_participated' => $eventEntrant,
        ]);
    }

    /**
     * @Route("/editProfile", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user, ['profile' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // set encode password
            $password = $user->getPassword();
            $encodePassword = $passwordEncoder->encodePassword($user, $password);
            $user->setPassword($encodePassword);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('front_profile');
        }

        return $this->render('front/profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete", name="delete")
     */
    public function delete(Request $request): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$user->getSlug(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setDeleted(1);
            $entityManager->flush();
        }

        return $this->render('front/default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
