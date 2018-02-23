<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="Accounts", indexes={
 *                                          @ORM\Index(name="User_Email_uindex", columns={"email"}),
 *                                          @ORM\Index(name="User_Login_uindex", columns={"username"})
 *                                          })
 * @UniqueEntity(fields="email", message="This email already taken")
 * @UniqueEntity(fields="username", message="This username already taken")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer", name="id_user")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_user;

    /**
     * @ORM\Column(type="string", length=30, name="username", unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100, name="password")
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=40, name="email", unique=true)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60, name="full_name", nullable=true)
     */
    private $full_name;

    /**
     * @ORM\Column(type="string", length=300, name="token")
     */
    private $token;

    /**
     * @ORM\ManyToOne(targetEntity="Access")
     * @ORM\JoinColumn(name="id_access", referencedColumnName="id_access")
     */
    private $access;

    /**
     * @ORM\ManyToOne(targetEntity="UserCondition")
     * @ORM\JoinColumn(name="id_condition", referencedColumnName="id_condition")
     */
    private $condition;

    public function setUsername(string $login)
    {
        $this->username = $login;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setFullName(string $name)
    {
        $this->full_name = $name;
    }

    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function setAccess(Access $access)
    {
        $this->access = $access;
    }

    public function setCondition(UserCondition $condition)
    {
        $this->condition = $condition;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFullName()
    {
        return $this->full_name;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function getRoles()
    {
        return array($this->access->getName());
    }

    public function getCondition()
    {
        return array($this->condition->getName());
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id_user,
            $this->username,
            $this->password,
            $this->email,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id_user,
            $this->username,
            $this->password,
            $this->email,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
}
