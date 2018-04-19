<?php

namespace App\Controller;

use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CanvasesListController extends Controller
{
    /**
     * @Route("/rooms/{id_room}/canvases", name="canvases_list")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function roomsListAction(Request $request, int $id_room, EntityManagerInterface $em)
    {
        $qb2 = $em->createQueryBuilder();
        $qb2->select()
            ->from(Room::class, 'r')
            ->leftJoin("r.pictures", "p")
            ->leftJoin("p.canvases", "c")
            ->addSelect('c.canvasName')
            ->addSelect('c.idCanvas')
            ->andWhere('r.idRoom=' . $id_room)
        ;

        $em->flush();

        $results = $qb2->getQuery()->getResult();

        if (is_null($results[0]['idCanvas'])) {
            $results = [];
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $results,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('CanvasesTemplates/canvases_list.html.twig', [
            'pagination'        => $pagination,
            'idRoom'            => $id_room,
        ]);
    }


}

