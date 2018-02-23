<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="User_Conditions")
 */
class UserCondition
{
    /**
     * @ORM\Column(type="integer", name="id_condition")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_condition;

    /**
     * @ORM\Column(type="string", length=30, name="name", nullable=true)
     */
    private $name;

    public function setAccessName(string $condition_name)
    {
        $this->name = $condition_name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getIdAccess()
    {
        return $this->id_condition;
    }
}