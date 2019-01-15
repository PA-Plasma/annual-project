<?php

namespace App\Controller\Front;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController
 *
 * @category  Class
 * @package   App\Controller\Front
 * @Route("/", name="security_")
 */
class SecurityController extends AbstractController
{
    /**
     * Register Action
     *
     * @Route("register", name="register")
     *
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);
            $user->addRole('ROLE_USER');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render(
            'front/security/register.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Login Action
     *
     * @Route("login", name="login")
     *
     * @param Request             $request
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        //
        $form = $this->get('form.factory')->createNamedBuilder(null)->add('_username', null, ['label' => 'Email'])->add(
            '_password',
            \Symfony\Component\Form\Extension\Core\Type\PasswordType::class,
            ['label' => 'Mot de passe']
        )->add(
            'ok',
            \Symfony\Component\Form\Extension\Core\Type\SubmitType::class,
            ['label' => 'Ok', 'attr' => ['class' => 'btn-primary btn-block']]
        )->getForm();

        return $this->render(
            'front/security/login.html.twig',
            [
                'mainNavLogin'  => true,
                'title'         => 'Connexion',
                'form'          => $form->createView(),
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }

    /**
     * Logout action
     *
     * @Route("logout", name="logout")
     *
     * @return void
     * @throws \Exception
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
