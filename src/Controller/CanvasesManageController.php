<?php

namespace App\Controller;

use App\Entity\Canvas;
use App\Entity\Picture;
use App\Entity\Room;
use App\Form\CanvasAddForm;
use App\Form\RoomAddForm;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CanvasesManageController extends Controller
{
    /**
     * @Route("/rooms/{id_room}/canvases/add", name="canvas_add")
     * @param Request $request
     * @return
     */
    public function addCanvasAction(Request $request, int $id_room)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CanvasAddForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $room = $this->getDoctrine()
                ->getRepository(Room::class)
                ->find($id_room);
            $picture = new Picture();
            $picture->setPictureName('-');
            $picture->setRoom($room);
            $em->persist($picture);

            $canvas = new Canvas();
            $data = $form->getData();
            $canvas->setCanvasName($data['canvas_name']);
            $canvas->setFlagActive(true);
            $canvas->setPicture($picture);

            $filePath = 'image_room/'.$data['canvas_name'].'.txt';
            $relativeFilePath = 'public/image_room/'.$data['canvas_name'].'.txt';
            if (!file_exists($filePath)) {
                $fp = fopen($filePath, 'w');
                fclose($fp);
                chmod($filePath, "0750");
            }
            $canvas->setCanvasFilePath($relativeFilePath);

            $em->persist($canvas);
            $em->flush();

            $url = $this->generateUrl('canvases_list', ['id_room' => $id_room]);
            return $this->redirect($url);
        }

        return $this->render('CanvasesTemplates/canvases_add.html.twig', [
          'form'        => $form->createView(),
        ]);
    }
}

