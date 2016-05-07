<?php

namespace Ticket\Controller;

use Ticket\Entity\Category;
use Ticket\Entity\Comment;
use Ticket\Entity\Ticket;
use Ticket\Service\ITicketService;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class TicketController {

    public function addTicket(Request $request, Application $app) {
        $categories = $app['service.categories']->getAll();

        return $app['twig']->render('add_ticket.twig', array('categories' => $categories));
    }

    public function saveTicket(Request $request, Application $app) {
        $user = $app['security.token_storage']->getToken()->getUser();


        $ticketId = $request->request->get('ticket_id');
        $title = $request->request->get('title');
        $content = $request->request->get('content');
        $categories = $request->request->get('category');

        if (!empty($ticketId)) {
            $ticket = $app['service.tickets']->getTicketById($ticketId);
        } else {
            $ticket = new Ticket();
        }

        $ticket->setUser($user);
        $ticket->setTitle($content);
        $ticket->setContent($content);

        if (is_array($categories)) {
            foreach ($categories as $categoryId) {
                if (!empty($categoryId)) {
                    $category = $app['service.categories']->getCategoryById($categoryId);
                    $ticket->addCategory($category);
                }
            }
        }

        $ticket = $app['service.tickets']->saveTicket($ticket);

        return $app->redirect('/');
    }

    public function addComment(Request $request, Application $app) {

        $params = $request->attributes->all();

        if (isset($params['ticket_id']) && !empty($params['ticket_id'])) {

            $ticket = $app['service.tickets']->getTicketById($params['ticket_id']);

            $categoriesString = '';
            foreach ($ticket->getCategories() as $category) {
                $categoriesString .= $category->getTitle() . ', ';
            }

            return $app['twig']->render('add_comment.twig', array('ticket' => $ticket, 'categories' => $categoriesString));
        } else {
            return $app->redirect('/');
        }
    }

    public function saveComment(Request $request, Application $app) {
        $params = $request->attributes->all();
        if (isset($params['ticket_id']) && !empty($params['ticket_id'])) {
            $user = $app['security.token_storage']->getToken()->getUser();

            $title = $request->request->get('title');
            $content = $request->request->get('content');

            $ticket = $app['service.tickets']->getTicketById($params['ticket_id']);

            $comment = new Comment();
            $comment->setTicket($ticket);
            $comment->setContent($content);
            $comment->setUser($user);

            $ticket->addComment($comment);

            $app['service.tickets']->saveTicket($ticket);

            return $app->redirect('/add_comment/' . $params['ticket_id']);
        } else {
            return $app->redirect('/');
        }
    }

    public function addCategory(Request $request, Application $app) {
        return $app['twig']->render('add_category.twig');
    }

    public function saveCategory(Request $request, Application $app) {

        $title = $request->request->get('title');
        $category = new Category();
        $category->setTitle($title);

        $app['service.categories']->createCategory($category);

        return $app->redirect('/');
    }
}
