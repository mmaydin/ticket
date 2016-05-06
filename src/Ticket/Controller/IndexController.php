<?php

namespace Ticket\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class IndexController {

    public function login(Request $request, Application $app) {
        return $app['twig']->render('login.twig');
    }
}
