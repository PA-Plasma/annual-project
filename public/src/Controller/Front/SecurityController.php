<?php

namespace App\Controller\Front;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginFormAuthenticator;
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
    public function registerAction(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request, UserPasswordEncoderInterface $passwordEncoder)
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
            $this->addFlash('success', 'Inscription Réussie');

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,          // the User object you just created
                $request,
                $authenticator, // authenticator whose onAuthenticationSuccess you want to use
                'main'          // the name of the firewall in security.yaml
            );
        }
        elseif ($form->isSubmitted()) {
            $this->addFlash('error', 'Formulaire incorrect');
        }
        return $this->render(
            'front/security/register.html.twig',
            [
                'securityForm' => $form->createView()
            ]
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
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->get('form.factory')->createNamedBuilder(null)->getForm();
        if($error){
            $this->addFlash('error', 'Identifiants incorrect');
        }

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
