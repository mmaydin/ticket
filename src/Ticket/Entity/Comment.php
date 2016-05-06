<?php
namespace Ticket\Entity;

/**
 * @Entity
 * @Table(name="comments")
 */
class Comment {

    /**
     * @var integer $id
     *
     * @Column(name="id", type="integer")
     * @id
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ManyToOne(targetEntity="Ticket",inversedBy="comments") */
    protected $ticket;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="comments")
     */
    protected $user;

    /** @Column(type="datetime")
     * @var \Datetime $createdAt
     */
    protected $createdAt;

    /** @Column(name="content", type="text") */
    protected $content;

    public function getId() {
        return $this->id;
    }

    public function getTicket() {
        return $this->ticket;
    }

    public function setTicket(Ticket $ticket) {
        $this->ticket = $ticket;

        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser(User $user) {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;

        return $this;
    }
}
