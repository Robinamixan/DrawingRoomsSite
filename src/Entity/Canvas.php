<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Canvases")
 */
class Canvas
{
    /**
     * @ORM\Column(type="integer", name="intIdCanvas")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idCanvas;

    /**
     * @ORM\Column(type="string", length=100, name="strCanvasName")
     */
    private $canvasName;

    /**
     * @ORM\Column(type="string", length=200, name="strCanvasFilePath")
     */
    private $canvasFilePath;

    /**
     * @return mixed
     */
    public function getCanvasFilePath()
    {
        return $this->canvasFilePath;
    }

    /**
     * @param mixed $canvasFilePath
     */
    public function setCanvasFilePath($canvasFilePath): void
    {
        $this->canvasFilePath = $canvasFilePath;
    }

    /**
     * @ORM\Column(type="boolean", name="blFlagActive", nullable=true)
     */
    private $flagActive;

    /**
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="canvases")
     * @ORM\JoinColumn(name="intIdRoom", referencedColumnName="intIdRoom")
     */
    private $room;

    public function __construct()
    {
        $this->flagActive = false;
    }

    public function setCanvasName(string $text)
    {
        $this->canvasName = $text;
    }

    public function setFlagActive(bool $flag)
    {
        $this->flagActive = $flag;
    }

    public function setRoom(Room $question)
    {
        $this->room = $question;
    }

    public function getCanvasName()
    {
        return $this->canvasName;
    }

    public function getFlagActive()
    {
        return $this->flagActive;
    }

    public function getIdCanvas()
    {
        return $this->idCanvas;
    }

    public function getRoom()
    {
        return $this->room;
    }

    public function __toString()
    {
        return $this->canvasName;
    }
}