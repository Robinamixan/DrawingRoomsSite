<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Room_Accesses")
 */
class RoomAccess
{
    /**
     * @ORM\Column(type="integer", name="intIdRoomAccess")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idAccess;

    /**
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="roomAccess")
     * @ORM\JoinColumn(name="intIdRoom", referencedColumnName="intIdRoom")
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="intIdUser", referencedColumnName="intIdUser")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Access")
     * @ORM\JoinColumn(name="intIdAccess", referencedColumnName="id_access")
     */
    private $access;

    /**
     * @return mixed
     */
    public function getIdAccess()
    {
        return $this->idAccess;
    }

    /**
     * @param mixed $idAccess
     */
    public function setIdAccess($idAccess): void
    {
        $this->idAccess = $idAccess;
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

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @param mixed $access
     */
    public function setAccess($access): void
    {
        $this->access = $access;
    }


}