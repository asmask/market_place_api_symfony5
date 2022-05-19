<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ServiceDataPersister implements DataPersisterInterface
{
    private $entityManager;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }


    public function supports($data):bool
    {
        return $data instanceof Service;
    }

    /**
     * @param Service $data
     */
    public function persist($data)
    {
        $data->setRoles(["ROLE_SERVICE"]);
        if ($data->getPassword()) {
            $data->setPassword($this->userPasswordHasher->hashPassword($data, $data->getPassword()));
            $data->eraseCredentials();
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}