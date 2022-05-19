<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Client;
    }

    /**
     * @param Client $data
     */
    public function persist($data, array $context = [])
    {
        $data->setRoles(["ROLE_CLIENT"]);

        if ($data->getPassword()) {
            $data->setPassword($this->userPasswordHasher->hashPassword($data, $data->getPassword()));
            $data->eraseCredentials();
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}