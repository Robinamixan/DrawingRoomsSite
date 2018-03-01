<?php

namespace App\Controller;


use App\Form\LoginForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticateController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function authenticateAction(AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
                '_username' => $lastUsername
            ]);

        return $this->render('security/login.html.twig', array(
            'form' => $form->createView(),
            'error' => $error
        ));
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }


}
