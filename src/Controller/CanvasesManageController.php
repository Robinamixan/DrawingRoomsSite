<?php

namespace App\Controller;

use App\Entity\Canvas;
use App\Entity\Picture;
use App\Entity\Room;
use App\Form\CanvasAddForm;
use App\Form\CanvasEditForm;
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
     *
     * @param Request $request
     * @param int $id_room
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
            $canvas->setCanvasFilePath('-');
            $em->persist($canvas);
            $em->flush();

            $filePath = 'image_room/'.$canvas->getIdCanvas().'_'.$canvas->getCanvasName().'.txt';
            $relativeFilePath = 'public/'.$filePath;
            if (!file_exists($filePath)) {
                $fp = fopen($filePath, 'w');
                fclose($fp);
            }
            $canvas->setCanvasFilePath($relativeFilePath);
            $em->persist($canvas);
            $em->flush();

            $url = $this->generateUrl('canvases_list', ['id_room' => $id_room]);

            return $this->redirect($url);
        }

        return $this->render(
            'CanvasesTemplates/canvases_add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/rooms/{id_room}/canvases/{id_canvas}/edit", name="canvas_edit")
     *
     * @param Request $request
     * @param int $id_room
     * @param int $id_canvas
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editCanvasAction(Request $request, int $id_room, int $id_canvas)
    {
        $em = $this->getDoctrine()->getManager();
        $canvas = $em->getRepository(Canvas::class)->find($id_canvas);
        $oldName = $canvas->getCanvasName();

        $form = $this->createForm(
            CanvasEditForm::class,
            ['canvas_name' => $oldName]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $canvas->setCanvasName($data['canvas_name']);

            $oldFile = 'image_room/'.$canvas->getIdCanvas().'_'.$oldName.'.txt';
            if (file_exists($oldFile)) {
                $fileContain = file_get_contents($oldFile);
                unlink($oldFile);
            }

            $filePath = 'image_room/'.$canvas->getIdCanvas().'_'.$canvas->getCanvasName().'.txt';
            $relativeFilePath = 'public/'.$filePath;
            if (!file_exists($filePath)) {
                $fp = fopen($filePath, 'w');
                fclose($fp);
            }
            file_put_contents($filePath, $fileContain);
            $canvas->setCanvasFilePath($relativeFilePath);

            $em->persist($canvas);
            $em->flush();

            $url = $this->generateUrl('canvases_list', ['id_room' => $id_room]);

            return $this->redirect($url);
        }

        return $this->render(
            'CanvasesTemplates/canvases_add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/rooms/{id_room}/canvases/{id_canvas}/delete", name="canvas_delete")
     *
     * @param Request $request
     * @param int $id_room
     * @param int $id_canvas
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteCanvasAction(Request $request, int $id_room, int $id_canvas)
    {
        $em = $this->getDoctrine()->getManager();
        $canvas = $em->getRepository(Canvas::class)->find($id_canvas);
        $oldName = $canvas->getCanvasName();

        $oldFile = 'image_room/'.$canvas->getIdCanvas().'_'.$oldName.'.txt';
        if (file_exists($oldFile)) {
            unlink($oldFile);
        }
        $picture = $canvas->getPicture();

        $em->remove($canvas);
        $em->remove($picture);
        $em->flush();

        $url = $this->generateUrl('canvases_list', ['id_room' => $id_room]);

        return $this->redirect($url);
    }
}

