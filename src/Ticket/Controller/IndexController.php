<?php

namespace Ticket\Controller;

use Ticket\Entity\Ticket;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class IndexController {

    public function login(Request $request, Application $app) {
        return $app['twig']->render('login.twig');
    }

    public function index(Request $request, Application $app) {

        $user = $app['security.token_storage']->getToken()->getUser();

        if (in_array('ROLE_USER', $user->getRoles())) {
            $tickets = $app['service.tickets']->getTicketsByUser($user);

            return $app['twig']->render('userdashboard.twig', array('tickets' => $tickets));
        } else {
            $totalCount = $app['service.tickets']->countAll();
            $newCount = $app['service.tickets']->countByStatus(Ticket::STATUS_NEW);
            $waitingCount = $app['service.tickets']->countByStatus(Ticket::STATUS_WAITING);
            $closedCount = $app['service.tickets']->countByStatus(Ticket::STATUS_CLOSED);

            return $app['twig']->render('dashboard.twig', array(
                                                            'totalCount' => $totalCount,
                                                            'closedCount' => $closedCount,
                                                            'newCount' => $newCount,
                                                            'waitingCount' => $waitingCount
                                                        ));
        }
    }
}
