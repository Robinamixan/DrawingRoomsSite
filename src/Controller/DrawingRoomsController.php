<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DrawingRoomsController extends Controller
{
    private $user;

    /**
     * @Route("/drawing/rooms", name="drawing_rooms")
     */
    public function index()
    {
        $roomsNames = [];
        foreach (glob("image_room/*.txt") as $filename) {
            $roomsNames[] = basename($filename, ".txt");
        }

        if (session_status() != 2) {
            session_start();
        }
        if ($_SESSION['user'] != null){
            $this->user = $_SESSION['user'];
        }
        else{
            $this->user['photo'] = "images/user.png";
            $this->user['first_name'] = "undefined user";
        }

        return $this->render('DrawingRooms/drawingroomslist.html.twig', array(
            'roomsNames' => $roomsNames,
            'userPhoto' => $this->user['photo'],
            'userFirstName' => $this->user['first_name'],
            'userLastName' => $this->user['last_name']
        ));
    }


    /**
     * @Route("/drawing/canvas", name="room_canvas")
     */
    public function canvasAction()
    {
        return $this->render('DrawingRooms/drawcanvas.html.twig', array());
    }

    /**
     * @Route("/user/exit", name="user_exit")
     */
    public function userExitAction()
    {
        session_start();
        $_SESSION['user'] = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]);
        }
        session_destroy();

        return $this->redirect('main_page');
    }

    /**
     * @Route("/rooms/add", name="room_add")
     * @param Request $request
     * @return JsonResponse
     */
    public function addRoomAction(Request $request)
    {
        $roomName = $request->request->get('room_name');

        $file = 'image_room/'.$roomName.'.txt';
        if (!file_exists($file)) {
            $fp = fopen($file, 'w');
            fclose($fp);
            chmod($file, "0750");
        }
        $arrData = ['room_name' => $roomName];

        return new JsonResponse($arrData);
    }

    /**
     * @Route("/rooms/delete", name="room_delete")
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteRoomAction(Request $request)
    {
        $roomName = $request->request->get('room_name');
        if (!is_null($roomName)) {
            $file = 'image_room/'.$roomName.'.txt';
            if (file_exists($file)) {
                unlink($file);
            }
        }
        $arrData = ['room_name' => $roomName];

        return new JsonResponse($arrData);
    }


}
