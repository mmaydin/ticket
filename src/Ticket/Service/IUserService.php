<?php
namespace Ticket\Service;

use Ticket\Entity\User;
use Ticket\Exception\EntityNotFoundException;

interface IUserService {

    public function getByUsername($username);
    public function findAll();
    public function getByEmail($email);
    public function getById($id);
    public function create(User $user);
    public function update(User $user);
}
