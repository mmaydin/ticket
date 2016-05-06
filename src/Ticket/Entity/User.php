<?php

namespace Ticket\Entity;

use Ticket\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Entity
 * @Table(name="users")
 */
class User implements UserInterface {

    /**
     * @var integer
     *
     * @Column(type="integer")
     * @id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", unique=TRUE)
     */
    protected $username;

    /**
     * @Column(type="string")
     */
    protected $password;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Column(type="string", unique=TRUE)
     */
    protected $email;

    /**
     * @Column(type="string")
     */
    protected $salt;

    /**
     * @Column(type="datetime")
     */
    protected $createdAt;

     /**
      * @Column(type="datetime")
      */
     protected $updatedAt;

     /**
      * @Column(type="datetime",nullable=TRUE)
      */
     protected $lastLogin;

    /**
     * @Column(type="string")
     */
    protected $roles;

    /**
     * @OneToMany(targetEntity="Ticket", mappedBy="user")
     * @var Ticket[]
     */
    protected $tickets = null;

    function __construct() {
        $this->tickets = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    function getPassword() {
        return $this->password;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function getLastLogin() {
        return $this->lastLogin;
    }

    function setLastLogin($lastlogin) {
        $this->lastLogin = $lastLogin;
    }

    function getRoles() {
        return array($this->roles);
    }

    function getSalt() {
        return $this->salt;
    }

    public function eraseCredentials() {

    }
}
