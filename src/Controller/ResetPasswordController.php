<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\CheckEmailForm;
use App\Form\ResetPasswordForm;
use App\Service\SecurityMailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends Controller
{
    /**
     * @Route("/check_email", name="check")
     */
    public function checkEmailAction(Request $request, SecurityMailer $securityMailer)
    {
        $form = $this->createForm(CheckEmailForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form_data = $form->getData();

            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneByEmail($form_data['email']);

            if($user) {
                $securityMailer->sendMailResetPassword($user);
            }
            $url = $this->generateUrl('homepage');
            return $this->redirect($url);
        }

        return $this->render('security/check_email.html.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
     * @param Request $request
     *
     * @Route("/reset_password", name="reset_password")
     */
    public function resetPasswordAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em   = $this->getDoctrine()->getManager();
        $token = $request->query->get('token');
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneByToken($token);

        if ($user) {
            $form = $this->createForm(ResetPasswordForm::class);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $form_data = $form->getData();
                $password = $passwordEncoder->encodePassword($user, $form_data['password']);
                $user->setPassword($password);
                $em->persist($user);
                $em->flush();

                $url = $this->generateUrl('homepage');
                return $this->redirect($url);
            }
            return $this->render('security/reset_password.html.twig', array(
                'form' => $form->createView(),
                'token' => $user->getToken(),
            ));
        }
        $url = $this->generateUrl('homepage');
        return $this->redirect($url);
    }
}
