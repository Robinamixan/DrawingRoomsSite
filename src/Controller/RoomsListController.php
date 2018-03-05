<?php

namespace App\Controller;

use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RoomsListController extends Controller
{
    /**
     * @Route("/rooms/list", name="rooms_list")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function roomsListAction(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        $qb2 = $em->createQueryBuilder();
        $qb2->select()
            ->from(Room::class, 'r')
            ->addSelect('r.roomName')
        ;

        $results = $qb2->getQuery()->getArrayResult();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $results,
            $request->query->getInt('page', 1),
            1
        );

        return $this->render('RoomsPages/rooms_list.html.twig', array(
            'pagination'        => $pagination,
        ));
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

