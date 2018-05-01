<?php

namespace App\Service\Data;

use App\Entity\User;

class UsersService extends BaseService
{
    public function findByEmail(string $email): ?User
    {
        return $this->em
            ->getRepository(User::class)
            ->findOneBy(array('email' => $email));
    }
}
