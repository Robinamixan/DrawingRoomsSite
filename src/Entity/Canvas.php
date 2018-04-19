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
     * @ORM\Column(type="string", length=100, name="strName")
     */
    private $canvasName;

    /**
     * @ORM\Column(type="string", length=200, name="strFilePath")
     */
    private $canvasFilePath;

    /**
     * @ORM\Column(type="boolean", name="blFlagActive", nullable=true)
     */
    private $flagActive;

    /**
     * @ORM\Column(type="string", length=1000, name="strSettings", nullable=true)
     */
    private $canvasSettings;

    /**
     * @ORM\ManyToOne(targetEntity="Picture", inversedBy="canvases")
     * @ORM\JoinColumn(name="intIdPicture", referencedColumnName="intIdPicture")
     */
    private $picture;

    public function __construct()
    {
        $this->flagActive = false;
    }

    public function getCanvasSettings()
    {
        return $this->canvasSettings;
    }

    public function setCanvasSettings($canvasSettings): void
    {
        $this->canvasSettings = $canvasSettings;
    }

    public function setCanvasName(string $text)
    {
        $this->canvasName = $text;
    }

    public function setFlagActive(bool $flag)
    {
        $this->flagActive = $flag;
    }

    public function setPicture(Picture $picture)
    {
        $this->picture = $picture;
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

    public function getPicture()
    {
        return $this->picture;
    }

    public function getCanvasFilePath()
    {
        return $this->canvasFilePath;
    }

    public function setCanvasFilePath($canvasFilePath): void
    {
        $this->canvasFilePath = $canvasFilePath;
    }

    public function __toString()
    {
        return $this->canvasName;
    }
}