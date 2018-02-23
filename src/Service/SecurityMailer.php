<?php
/**
 * Created by PhpStorm.
 * User: robinam
 * Date: 08.01.18
 * Time: 12:58
 */

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class SecurityMailer
{
    private $twig;
    private $router;
    private $mailer;

    function __construct(Environment $twig, UrlGeneratorInterface $router, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->mailer = $mailer;
    }

    public function sendMailResetPassword(User $user)
    {
        $token = $user->getToken();
        $url_reset = $this->router->generate('reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
        $message = (new \Swift_Message('Reset Password'))
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/reset_password.html.twig',
                    array(
                        'url_reset' => $url_reset,
                    )
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    public function sendMailConfirmRegistration(User $user)
    {
        $token = $user->getToken();
        $url_confirm = $this->router->generate('registration_confirm', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
        $message = (new \Swift_Message('Registration Confirmation'))
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/confirm_registration.html.twig',
                    array(
                        'url_confirm' => $url_confirm,
                    )
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }

}