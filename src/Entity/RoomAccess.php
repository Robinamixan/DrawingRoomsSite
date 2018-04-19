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
     * @ORM\ManyToOne(targetEntity="Room")
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
}