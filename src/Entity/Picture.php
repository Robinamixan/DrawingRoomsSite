<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Pictures")
 */
class Picture
{
    /**
     * @ORM\Column(type="integer", name="intIdPicture")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idPicture;

    /**
     * @ORM\Column(type="string", length=100, name="strName", nullable=true)
     */
    private $pictureName;

    /**
     * @ORM\Column(type="string", length=500, name="strDescription", nullable=true)
     */
    private $pictureDescription;

    /**
     * @ORM\OneToMany(targetEntity="Canvas", mappedBy="picture", cascade={"ALL"}, indexBy="idCanvas")
     */
    private $canvases;

    /**
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="pictures")
     * @ORM\JoinColumn(name="intIdRoom", referencedColumnName="intIdRoom")
     */
    private $room;

    /**
     * @return mixed
     */
    public function getIdPicture()
    {
        return $this->idPicture;
    }

    /**
     * @param mixed $idPicture
     */
    public function setIdPicture($idPicture): void
    {
        $this->idPicture = $idPicture;
    }

    /**
     * @return mixed
     */
    public function getPictureName()
    {
        return $this->pictureName;
    }

    /**
     * @param mixed $pictureName
     */
    public function setPictureName($pictureName): void
    {
        $this->pictureName = $pictureName;
    }

    /**
     * @return mixed
     */
    public function getPictureDescription()
    {
        return $this->pictureDescription;
    }

    /**
     * @param mixed $pictureDescription
     */
    public function setPictureDescription($pictureDescription): void
    {
        $this->pictureDescription = $pictureDescription;
    }

    /**
     * @return mixed
     */
    public function getCanvases()
    {
        return $this->canvases;
    }

    /**
     * @param mixed $canvases
     */
    public function setCanvases($canvases): void
    {
        $this->canvases = $canvases;
    }

    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     */
    public function setRoom($room): void
    {
        $this->room = $room;
    }


}