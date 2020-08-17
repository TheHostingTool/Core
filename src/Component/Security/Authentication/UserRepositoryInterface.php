<?php

namespace TheHostingTool\Component\Security\Authentication;

use Doctrine\ORM\NoResultException;
use TheHostingTool\Component\Persistence\Repository\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{

    /**
     * Returns the user with the given id.
     *
     * @param int $id The user to find
     * @return UserInterface
     */
    public function findUserById(int $id);


    /**
     * Returns the users with the given ids.
     *
     * @param array $ids The ids of the users to load
     * @return UserInterface[]
     */
    public function findUsersByIds(array $ids);

    /**
     * Returns the user with the given email
     *
     * @param string $email The email of the user to find
     * @return UserInterface
     * @throws NoResultException
     */
    public function findUserByEmail(string $email);

    /**
     * Finds a user with the given security id
     *
     * @param int $id The id of the user to find
     * @return UserInterface
     */
    public function findUserWithSecurityById(int $id);

    /**
     * Finds a user for a given email or username.
     *
     * @param string $identifier The email address or username.
     * @return UserInterface
     * @throws NoResultException if the user is not found.
     */
    public function findUserByIdentifier(string $identifier);


}