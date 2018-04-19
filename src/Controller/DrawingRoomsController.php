<?php

namespace App\Controller;

use App\Entity\Canvas;
use Doctrine\ORM\EntityManagerInterface;
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
            $roomsNames[] = basename($filename, '.txt');
        }

        if (array_key_exists('user', $_SESSION)) {
            $this->user = $_SESSION['user'];
        } else {
            $this->user['photo'] = $this->generateUrl('main_page') . "assets/images/user.png";
            $this->user['first_name'] = 'undefined user';
            $this->user['last_name'] = '';
        }

        return $this->render('DrawingRooms/drawingroomslist.html.twig', array(
            'roomsNames' => $roomsNames,
            'userPhoto' => $this->user['photo'],
            'userFirstName' => $this->user['first_name'],
            'userLastName' => $this->user['last_name'],
        ));
    }

    /**
     * @Route("/drawing/canvas/{id_canvas}", name="room_canvas")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function canvasAction(Request $request, int $id_canvas, EntityManagerInterface $em)
    {

        $canvas = $this->getDoctrine()
            ->getRepository(Canvas::class)
            ->find($id_canvas);

        $canvas_title = $canvas->getCanvasName();
        $canvas_title = $canvas_title ? $canvas_title: 'Room 1';
        return $this->render('DrawingRooms/drawcanvas.html.twig', array(
            'canvas_title' => $canvas_title,
            'canvas_path' => $canvas->getCanvasFilePath(),
        ));
    }
}
