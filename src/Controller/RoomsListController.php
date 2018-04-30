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
        $qb2 = $em->createQueryBuilder();
        $qb2->select()
            ->from(Room::class, 'r')
            ->leftJoin("r.roomAccess", "a")
            ->leftJoin("a.user", "u")
            ->addSelect('u.username')
            ->addSelect('r.roomName')
            ->addSelect('r.roomDescription')
            ->addSelect('r.idRoom')
            ->addOrderBy('r.idRoom')
        ;

        $results = $qb2->getQuery()->getArrayResult();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $results,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('RoomsPages/rooms_list.html.twig', [
            'pagination'        => $pagination,
        ]);
    }


}

