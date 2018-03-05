<?php

namespace App\Controller;

use App\Entity\Access;
use App\Entity\User;
use App\Form\RegistrationForm;
use App\Service\SecurityMailer;
use App\Entity\UserCondition;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/registration", name="registration")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registrationAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(RegistrationForm::class, $user);

        $form->handleRequest($request);

        return $this->render('security/registration.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param SecurityMailer $securityMailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/create", name="create")
     */
    public function createAction(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        SecurityMailer $securityMailer
    ) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RegistrationForm::class, new User());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $token = md5($user->getEmail().rand().time());
            $user->setToken($token);

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $access = $this->getDoctrine()
                ->getRepository(Access::class)
                ->findOneBy(['name' => 'ROLE_USER']);

            $condition = $this->getDoctrine()
                ->getRepository(UserCondition::class)
                ->findOneBy(['name' => 'Not confirmed']);

            $user->setAccess($access);
            $user->setCondition($condition);

            $em->persist($user);
            $em->flush();

            $securityMailer->sendMailConfirmRegistration($user);

            $url = $this->generateUrl('login');

            return $this->redirect($url);
        }

        return $this->render('security/registration.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     *
     * @Route("/registration_confirm", name="registration_confirm")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registrationConfirmAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token = $request->query->get('token');
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['token' => $token]);

        if ($user) {
            $condition = $this->getDoctrine()
                ->getRepository(UserCondition::class)
                ->findOneBy(['name' => 'Active']);
            $user->setCondition($condition);
            $em->persist($user);
            $em->flush();
        }

        return $this->render('security/registration_confirmed.html.twig', array());
    }
}
