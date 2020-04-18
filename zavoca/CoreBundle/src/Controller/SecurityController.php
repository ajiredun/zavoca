<?php

namespace Zavoca\CoreBundle\Controller;

use Zavoca\CoreBundle\Entity\User;
use Zavoca\CoreBundle\Service\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="zavoca_core_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('zavoca/core/security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @param Request $request
     * @param UserManager $userManager
     * @return Response
     *
     * @Route("/register", name="zavoca_core_register")
     */
    public function register(Request $request, UserManager $userManager): Response
    {
        $error = null;
        $success = null;
        if (
        $request->isMethod('POST')
        ) {
            if (
                $request->request->get('inputEmail') &&
                $request->request->get('inputFirstname') &&
                $request->request->get('inputLastname') &&
                $request->request->get('inputPassword') &&
                $request->request->get('inputConfirmPassword')
            ) {
                if ($request->request->get('inputPassword') === $request->request->get('inputConfirmPassword')) {

                    $email = $request->request->get('inputEmail');

                    if (!$userManager->isUserExist($email)) {
                       $userManager->createUser([
                            'firstname' => $request->request->get('inputFirstname'),
                            'lastname' => $request->request->get('inputLastname'),
                            'email' => $email,
                            'password' => $request->request->get('inputPassword'),
                        ]);

                        $success = "Please activate your account by clicking on the link we sent by mail.";
                    } else {
                        $error = "An account with this email address already exists.";
                    }
                } else {
                    $error = "The two passwords don't match.";
                }
            } else {
                $error = "Please fill in all the details";
            }
        }

        return $this->render('zavoca/core/security/register.html.twig', [
            'success' => $success,
            'error' => $error,
            'inputEmail' => $request->request->get('inputEmail'),
            'inputFirstname' => $request->request->get('inputFirstname'),
            'inputLastname' => $request->request->get('inputLastname')
        ]);
    }

    /**
     * @param Request $request
     * @param UserManager $userManager
     * @return Response
     *
     * @Route("/forget", name="zavoca_core_forget_password")
     */
    public function forgetPassword(Request $request, UserManager $userManager): Response
    {
        $error = null;

        if ($request->isMethod('POST')) {
            if (!empty($request->request->get('input_email'))) {
                $email = $request->request->get('input_email');
                $ur = $this->getDoctrine()->getRepository(User::class);
                $user = $ur->findOneBy(array('email'=>$email));
                if ($user) {
                    $userManager->setPassword($user);
                    $this->getDoctrine()->getManager()->flush();

                    $error = "We sent you an Email.";
                } else {
                    $error = "There is no account with this email address.";
                }
            } else {
                $error = "Please enter the recovery email address.";
            }
        }

        return $this->render('zavoca/core/security/forgetPassword.html.twig', ['error' => $error]);
    }

    /**
     * @Route("/logout", name="zavoca_core_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
