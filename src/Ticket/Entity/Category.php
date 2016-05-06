<?php
namespace Ticket\Entity;

/**
 * @Entity
 * @Table(name="categories")
 */
class Category {

    /**
     * @var integer $id
     *
     * @id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(name="title", type="string", length=64)
     */
    protected $title;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
}

