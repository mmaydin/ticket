<?php

namespace Ticket\Controller;

use Ticket\Entity\Ticket;
use Ticket\Service\ITicketService;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class TicketController {

    private $ticketService;

    public function __construct(ITicketService $ticketService){
        $this->ticketService = $ticketService;
    }

    public function addTicket(Request $request, Application $app) {
        $categories = $app['service.categories']->findAll();

        return $app['twig']->render('add_ticket.twig', array('categories' => $categories));
    }

    public function saveTicket(Request $request, Application $app) {
        $title = $request->request->get('title');
        $content = $request->request->get('content');
        $categories = $request->request->get('category');

        $ticket = new Ticket();
        $ticket->setUserId(1);
        $ticket->setTitle($content);
        $ticket->setContent($content);
        $ticket->setCategories($categories);
        $ticket = $this->ticketService->saveTicket($ticket);

        return $app->redirect('/');
    }
}
