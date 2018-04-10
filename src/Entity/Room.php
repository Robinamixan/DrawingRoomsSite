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
     * @ORM\Column(type="string", length=300, name="strName")
     */
    private $roomName;

    /**
     * @ORM\Column(type="string", length=500, name="strDescription", nullable=true)
     */
    private $roomDescription;

    /**
     * @ORM\Column(type="string", length=50, name="strPassword", nullable=true)
     */
    private $roomPassword;

    /**
     * @ORM\OneToMany(targetEntity="Picture", mappedBy="room", cascade={"ALL"}, indexBy="idPicture")
     */
    private $pictures;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    public function setRoomName(?string $text): void
    {
        $this->roomName = $text;
    }

    public function setIdRoom(int $number): void
    {
        $this->idRoom = $number;
    }

    public function getRoomName()
    {
        return $this->roomName;
    }

    public function getCanvases()
    {
        return $this->pictures;
    }

    public function getIdRoom()
    {
        return $this->idRoom;
    }

    /**
     * @return mixed
     */
    public function getRoomDescription()
    {
        return $this->roomDescription;
    }

    /**
     * @param mixed $roomDescription
     */
    public function setRoomDescription($roomDescription): void
    {
        $this->roomDescription = $roomDescription;
    }

    /**
     * @return mixed
     */
    public function getRoomPassword()
    {
        return $this->roomPassword;
    }

    /**
     * @param mixed $roomPassword
     */
    public function setRoomPassword($roomPassword): void
    {
        $this->roomPassword = $roomPassword;
    }

    /**
     * @return mixed
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @param mixed $pictures
     */
    public function setPictures($pictures): void
    {
        $this->pictures = $pictures;
    }


}