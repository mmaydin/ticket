<?php
namespace Ticket\Service;

use Ticket\Entity\Ticket;
use Ticket\Entity\User;
use Ticket\Exception\EntityNotFoundException;

interface ITicketService {

    public function getAllTickets();
    public function getTicketById($id);
    public function getTicketsByUser(User $user);
    public function saveTicket(Ticket $ticket);
    public function countAll();
    public function countByStatus($status);

}
