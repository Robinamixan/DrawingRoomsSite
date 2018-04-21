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
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RoomAddForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $room = new Room();
            $data = $form->getData();
            $room->setRoomName($data['room_name']);
            $room->setRoomDescription($data['room_description']);
            if ($data['flag_add_password']) {
                $room->setRoomPassword($data['password']);
            }

            $em->persist($room);
            $em->flush();

            $url = $this->generateUrl('rooms_list');
            return $this->redirect($url);
        }

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

    }
}

