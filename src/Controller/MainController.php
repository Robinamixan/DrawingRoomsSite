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
    public function fileLoadAction(Request $request)
    {
        if (array_key_exists('token', $_POST)) {
            $ulogin_response = file_get_contents('http://ulogin.ru/token.php?token='.$_POST['token'].'&host='.$_SERVER['HTTP_HOST']);

            $user = json_decode($ulogin_response, true);

            if (!array_key_exists("error", $user)) {


                if (session_status() != 2) {
                    session_start();
                }

                $_SESSION['user'] = $user;

                return $this->redirect($this->generateUrl('drawing_rooms'));
            }
        }


        return $this->render('Authorization/authorization.html.twig', array());
    }
}