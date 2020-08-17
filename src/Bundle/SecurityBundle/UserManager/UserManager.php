<?php

namespace TheHostingTool\Bundle\SecurityBundle\UserManager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NoResultException;
use TheHostingTool\Component\Security\Authentication\UserInterface;
use TheHostingTool\Component\Security\Authentication\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class UserManager
{

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var EncoderFactory
     */
    protected $encoderFactory;

    public function __construct(
        ObjectManager $em,
        EncoderFactory  $encoderFactory = null,
        UserRepositoryInterface $userRepository = null
    ) {
        $this->em = $em;
        $this->encoderFactory = $encoderFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * Returns user for given id
     *
     * @param int $id userId
     */
    public function getUserById(int $id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * @return \Closure
     */
    public function delete()
    {
        $delete = function ($id) {
            $user = $this->userRepository->findUserById($id);
            if (!$user) {
                throw new EntityNotFoundException($this->userRepository->getClassName(), $id);
            }

            $this->em->remove($user);
            $this->em->flush();
        };

        return $delete;
    }

    /**
     * Return all users
     *
     * @return array
     */
    public function findAll()
    {
        return $this->userRepository->findAll();
    }

    public function save(array $data, string $locale, int $id = null, bool $patch = false, bool $flush = true)
    {
        $username = $this->getProperty($data, 'username');
        $email = $this->getProperty($data, 'email');
        $password = $this->getProperty($data, '$password');
        $enabled = $this->getProperty($data, 'enabled');
        $locked = $this->getProperty($data, 'locked');
        $user = null;

        try {
            if ($id) {
                // update user
                $user = $this->userRepository->findUserById($id);
                if (!$user) {
                    throw new EntityNotFoundException($this->userRepository->getClassName(), $id);
                }
            } else {
                // add user
            }
        }

        $this->em->persist($user);
        if ($flush) {
            $this->em->flush();
        }

        return $user;
    }

    /**
     * Return property for given key or default value.
     *
     * @param array $data
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    private function getProperty(array $data, string $key, $default = null)
    {
        if (array_key_exists($key, $data)) {
            return $data[$key];
        }

        return $default;
    }

}