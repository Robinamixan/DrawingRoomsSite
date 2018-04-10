<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="User_Favorites")
 */
class UserFavorites
{
    /**
     * @ORM\Column(type="integer", name="intIdFavorite")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idFavorite;

    /**
     * @ORM\Column(type="string", length=100, name="strEntityName")
     */
    private $entityName;

    /**
     * @ORM\Column(type="integer", name="intIdEntity")
     */
    private $idEntity;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="favorites")
     * @ORM\JoinColumn(name="intIdUser", referencedColumnName="intIdUser")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getIdFavorite()
    {
        return $this->idFavorite;
    }

    /**
     * @param mixed $idFavorite
     */
    public function setIdFavorite($idFavorite): void
    {
        $this->idFavorite = $idFavorite;
    }

    /**
     * @return mixed
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param mixed $entityName
     */
    public function setEntityName($entityName): void
    {
        $this->entityName = $entityName;
    }

    /**
     * @return mixed
     */
    public function getIdEntity()
    {
        return $this->idEntity;
    }

    /**
     * @param mixed $idEntity
     */
    public function setIdEntity($idEntity): void
    {
        $this->idEntity = $idEntity;
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


}