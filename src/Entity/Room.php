<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Rooms")
 */
class Room
{
    /**
     * @ORM\Column(type="integer", name="intIdRoom")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idRoom;

    /**
     * @ORM\Column(type="string", length=300, name="strRoomName")
     */
    private $roomName;

    /**
     * @ORM\OneToMany(targetEntity="Canvas", mappedBy="room", cascade={"ALL"}, indexBy="idCanvas")
     */
    public $canvases;

    public function __construct()
    {
        $this->canvases = new ArrayCollection();
    }

    public function setRoomName(?string $text): void
    {
        $this->roomName = $text;
    }

    public function setIdRoom(int $number): void
    {
        $this->idRoom = $number;
    }

    public function addAnswer()
    {
//        $text = "sdsdsd";
//        $flag = true;
//        $canvas = new Canvas();
//        $canvas->setCanvasName($text);
//        $canvas->setFlagActive($flag);
//        $canvas->setQuestion($this);
//        $this->canvases[] = $canvas;
    }

    public function getRoomName()
    {
        return $this->roomName;
    }

    public function getCanvases()
    {
        return $this->canvases;
    }

    public function getIdRoom()
    {
        return $this->idRoom;
    }
}