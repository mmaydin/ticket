<?php

namespace Ticket\Manager;

use Ticket\Entity\User;
use Ticket\Service\IUserService;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserManager implements UserProviderInterface {
    /**
     * @var \Ticket\Service\IUserService $userService
     */
    protected $userService;
    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactory
     */
    protected $encoderFactory;
    protected $logger;

    function __construct(IUserService $userService, EncoderFactory $encoderFactory) {
        $this->userService = $userService;
        $this->encoderFactory = $encoderFactory;
    }
    /**
     * @return User user
     * @param string $username
     */
    public function loadUserByUsername($username) {
        return $this->userService->getByUsername($username);
    }
    public function findAll() {
        return $this->userService->findAll();
    }
    public function getByEmail($email) {
        return $this->userService->getByEmail($email);
    }
    function getById($id) {
        return $this->userService->getById($id);
    }
    public function refreshUser(UserInterface $user) {
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * 
     * @param User $user
     * @return bool
     */
    public function supportsClass($user) {
        return is_a($user, "User");
    }
    public function register(User $user) {
        if ($this->getByEmail($user->getEmail())) {
            throw new \Exception("Email {$user->getEmail()} already taken", 1);
        }
        if ($this->loadUserByUsername($user->getUsername())) {
            throw new \Exception("Username {$user->getEmail()} already taken", 1);
        }
        $this->setUserSalt($user);
        $password = $this->encodePassword($user);
        $user->setPassword($password);
        $user->setCreatedAt(new \DateTime('now'));
        $user->setUpdatedAt(new \DateTime('now'));
        $user->eraseCredentials();
        return $this->userService->create($user);
    }
    function encodePassword(User $user) {
        return $this->encoderFactory->getEncoder($user)
                        ->encodePassword($user->getPassword(), $user->getSalt());
    }
    function setNewPassword(User $user, $newPassword) {
        $this->setUserSalt($user);
        $user->setPassword($newPassword);
        $password = $this->encodePassword($user);
        $user->setPassword($password);
        $user->setUpdatedAt(new \DateTime("now"));
        $newUser = $this->userService->update($user);
        return $newUser;
    }
    function setNewPasswordByUsername($username, $newPassword) {
        $user = $this->userService->getByUsername($username);
        $modifiedUser = $this->setNewPassword($user, $newPassword);
        return $modifiedUser;
    }
    function setUserSalt(User $user) {
        $user->setSalt(md5(time()));
    }
}
