<?php

namespace App\Security;

use App\Entity\Access;
use App\Entity\User;
use App\Entity\UserCondition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class SocialButtonAuthenticator extends AbstractFormLoginAuthenticator
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
        $token = $request->get('token');
        $ulogin_response = file_get_contents('http://ulogin.ru/token.php?token='.$token.'&host='.$_SERVER['HTTP_HOST']);
        $user = json_decode($ulogin_response, true);
        $user_token = md5($user['nickname'] . $user['uid'] . $user['email']);
        $data['_username'] = $user['nickname'] . $user['uid'];
        $data['_password'] = $user['network'] . $user['uid'];
        $data['_token'] = $token;
        $data['user_social_info'] = $user;
        $data['user_token'] = $user_token;

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = null;
        if(!is_null($credentials['user_social_info'])) {
            $user = $this->em->getRepository('App:User')
                ->findOneBy(['token' => $credentials['user_token']]);

            if(!$user) {
                $user = $this->registrateSocialUser($credentials);
            }
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($this->userPasswordEncoder->isPasswordValid($user, $credentials['user_token'])) {
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

    protected function registrateSocialUser(array $credentials): User
    {
        $user = new User();

        $access = $this->em
            ->getRepository(Access::class)
            ->findOneBy(['name' => 'ROLE_USER']);

        $user_token = $credentials['user_token'];

        $password = $this->userPasswordEncoder->encodePassword($user, $credentials['user_token']);

        $condition = $this->em
            ->getRepository(UserCondition::class)
            ->findOneBy(['name' => 'Active']);

        $user->setEmail($credentials['user_social_info']['email']);
        $user->setUsername(
            $credentials['user_social_info']['nickname'] .
            $credentials['user_social_info']['uid']
        );
        $user->setPhotoPath($credentials['user_social_info']['photo']);
        $user->setPassword($password);
        $user->setAccess($access);
        $user->setToken($user_token);
        $user->setCondition($condition);
        $user->setFullName(
            $credentials['user_social_info']['first_name'] .
            ' ' .
            $credentials['user_social_info']['last_name']
        );

        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

}
