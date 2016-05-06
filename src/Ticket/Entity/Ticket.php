<?php
namespace Ticket\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Ticket\Entity\User;
use Ticket\Entity\Comment;
use Ticket\Entity\Category;


/**
 * @Entity
 * @Table(name="tickets")
 */
class Ticket {

    const STATUS_NEW = 'new';
    const STATUS_WAITING = 'waiting';
    const STATUS_CLOSED = 'closed';

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer")
     * @id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @Column(name="title", type="string", length=64) */
    protected $title;

    /**
      * @ManyToOne(targetEntity="User",inversedBy="tickets")
      */
    protected $user;

    /** @Column(type="datetime")
     * @var \Datetime $createdAt
     */
    protected $createdAt;

    /** @Column(name="content", type="text") */
    protected $content;
    
    /** @Column(name="gender", type="string") */
    protected $status;

    /**
     * @OneToMany(targetEntity="Comment", mappedBy="ticket")
     */
    protected $comments = array();

    /**
     * @ManyToMany(targetEntity="Category")
     */
    protected $categories = array();

    function __construct() {
        $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser(User $user) {
        $this->user = $user;

        return $this;
    }

    public function getDate() {
        return $this->date;
    }

    public function setCratedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    public function getCategories() {
        return $this->categories;
    }

    public function setCategories($categories) {
        $this->categories = $categories;

        return $this;
    }

    public function addCategory(Category $category) {
        $this->categories[] = $category;

        return $this;
    }

    public function removeCategory(Category $category) {
        $this->categories->removeElement($category);

        return  $this;
    }

    public function getComments() {
        return $this->comments;
    }

    public function setComments($comments) {
        $this->comments = $comments;

        return $this;
    }

    public function addComment(Comment $comment) {
        $this->comments[] = $comment;

        return $this;
    }

    public function removeComment(Comment $comment) {
        $this->comments->removeElement($comment);

        return  $this;
    }
}
