<?php

namespace TheHostingTool\Bundle\SecurityBundle\Repository;

use TheHostingTool\Bundle\SecurityBundle\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByUsername(string $username): ?User
    {
        $user = $this->findOneBy(['username' => $username]);

        return $user instanceof User ? $user : null;
    }

    public function findOneByEmail(string $email): ?User
    {
        $user = $this->findOneBy(['email' => $email]);

        return $user instanceof User ? $user : null;
    }
}