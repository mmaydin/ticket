<?php
$ticket = $app['controllers_factory'];

// Main page
$ticket->get('/', 'Ticket\Controller\IndexController::index')
->bind('main');

$ticket->get('/login', 'Ticket\Controller\IndexController::login')
->bind('login');

// Add category
$ticket->get('/add_category', 'Ticket\Controller\TicketController::addCategory')
->bind('add_category');

// Save category
$ticket->post('/save_category', 'Ticket\Controller\TicketController::saveCategory')
->bind('save_category');

// Add ticket
$ticket->get('/add_ticket', 'Ticket\Controller\TicketController::addTicket')
->bind('add_ticket');

// Save ticket
$ticket->post('/save_ticket', 'Ticket\Controller\TicketController::saveTicket')
->bind('save_ticket');

// Reopen ticket
$ticket->get('/reopen_ticket/{ticket_id}', 'Ticket\Controller\TicketController::reopenTicket')
->bind('reopen_ticket');

// Close ticket
$ticket->get('/close_ticket/{ticket_id}', 'Ticket\Controller\TicketController::closeTicket')
->bind('close_ticket');

// Add comment to get page
$ticket->get('/add_comment/{ticket_id}', 'Ticket\Controller\TicketController::addComment')
->bind('add_comment');

// Save comment to post page
$ticket->post('/save_comment/{ticket_id}', 'Ticket\Controller\TicketController::saveComment')
->bind('save_comment');

$app->mount('/', $ticket);
