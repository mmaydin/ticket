<?php

namespace Ticket\Entity;

/**
 * @Entity
 * @Table(name="roles")
 * */
class Role {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer")
     * @id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @Column(type="string", unique=TRUE) */
    protected $title;

    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function setTitle($val) {
        $this->title = $val;
        
        return $this;
    }

    function __toString(){
        return $this->title;
    }
}
