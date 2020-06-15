<?php

namespace TheHostingTool\Bundle\CoreBundle\Repository;

use TheHostingTool\Bundle\CoreBundle\Entity\Config;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Config::class);
    }

    public function findByName(string $name): ?Config
    {
        $config = $this->findOneBy(['name' => $name]);
        return $config instanceof Config ? $config : null;
    }
}