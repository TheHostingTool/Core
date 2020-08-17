<?php

namespace TheHostingTool\Component\Persistence\Repository;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Repository Interface
 */
interface RepositoryInterface extends ObjectRepository
{
    /**
     * Create a new instance of a model.
     */
    public function createNew();
}