<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomAddForm;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RoomsManageController extends Controller
{
    /**
     * @Route("/rooms/add", name="room_add")
     * @param Request $request
     * @return
     */
    public function addRoomAction(Request $request)
    {
        $form = $this->createForm(RoomAddForm::class);

//        $roomName = $request->request->get('room_name');
//
//        $file = 'image_room/'.$roomName.'.txt';
//        if (!file_exists($file)) {
//            $fp = fopen($file, 'w');
//            fclose($fp);
//            chmod($file, "0750");
//        }
//        $arrData = ['room_name' => $roomName];

        return $this->render('RoomsPages/rooms_add.html.twig', [
          'form'        => $form->createView(),
        ]);
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

