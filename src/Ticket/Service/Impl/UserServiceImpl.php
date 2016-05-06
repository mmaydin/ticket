<?php
namespace Ticket\Service\Impl;

use Ticket\Service\IUserService;
use Doctrine\ORM\EntityManager;
use Ticket\Entity\User;
use Ticket\Exception\EntityNotFoundException;

class UserServiceImpl implements IUserService {
	
	private $userRepository;
	private $entityManager;
	
	public function __construct(EntityManager $em) {
            $this->userRepository = $em->getRepository("Ticket\Entity\User");
            $this->entityManager = $em;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Ticket\Service\IUserService::findAll()
	 */
	public function findAll() {
            return $this->userRepository->findAll();
	}

	/**
	 * {@inheritDoc}
	 * @see \Ticket\Service\IUserService::getById()
	 */
	public function getById($id) {
            return $this->userRepository->find($id);
	}

        /**
	 * {@inheritDoc}
	 * @see \Ticket\Service\IUserService::getByEmail()
	 */
        public function getByEmail($email) {
            return $this->userRepository->findBy(array("email" => $email));
        }

        /**
	 * {@inheritDoc}
	 * @see \Ticket\Service\IUserService::getByUsername()
	 */
        public function getByUsername($username) {
            return $this->userRepository->findOneBy(array("username" => $username));
        }

	/**
	 * {@inheritDoc}
	 * @see \Ticket\Service\IUserService::create()
	 */
	public function create(User $user) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            
            return $user;
	}

        /**
	 * {@inheritDoc}
	 * @see \Ticket\Service\IUserService::update()
	 */
	public function update(User $user) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            
            return $user;
	}
}
