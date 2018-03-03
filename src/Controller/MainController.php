<?php
/**
 * Created by PhpStorm.
 * User: f.gorodkovets
 * Date: 19.2.18
 * Time: 12.04
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends Controller
{
    /**
     * Matches / exactly
     *
     * @Route("/", name="main_page")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainPageAction(Request $request)
    {
        if (is_null($this->getUser())) {
            $this->redirect($this->generateUrl('login'));
        }

        return $this->render('MainPage/main_page.html.twig');
    }
}