<?php

namespace App\Security;

use App\Form\LoginForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    private $formFactory;
    private $em;
    private $router;
    private $userPasswordEncoder;

    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $em,
        RouterInterface $router,
        UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function getCredentials(Request $request)
    {
        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);
        $data = $form->getData();

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['_username']
        );

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];
        $user = $this->em->getRepository('App:User')
            ->findOneBy(['username' => $username]);

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $passwordForm = $credentials['_password'];

        if ($this->userPasswordEncoder->isPasswordValid($user, $passwordForm)) {
            return true;
        }
        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }

    public function supports(Request $request)
    {
        $token = $request->get('token');
        if (!is_null($token)) {
            return null;
        }

        $isLoginSubmit = $request->getPathInfo() === '/login';
        if (!$isLoginSubmit) {

            return null;
        }

        if (!$request->isMethod('POST'))
        {
            return null;
        }
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $targetPath = $this->router->generate('main_page');

        return new RedirectResponse($targetPath);
    }
}
