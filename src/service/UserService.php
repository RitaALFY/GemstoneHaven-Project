<?php


namespace App\service;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) { }

    /**
     * @param User $user
     * @return string
     */
    public function encodeUserPassword(User $user): string {
        return $this->hasher->hashPassword($user, $user->getPassword());
    }

}

