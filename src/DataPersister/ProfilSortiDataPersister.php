<?php

namespace App\DataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Profil;
use App\Entity\ProfilSorti;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProfilSortiDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;
    private $repoProfil;

    public function __construct(
        ProfilRepository $repoProfil,
        EntityManagerInterface $entityManager
    ) {
        $this->_entityManager = $entityManager;
        $this->repoProfil=$repoProfil;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof ProfilSorti;
    }

    public function persist($data, array $context = [])
    {
        $data->setLibele($data->getLibele());
        $data->setArchivage(false);

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setArchivage(true);

        $users = $data->getUser();
        foreach ($users as $user) {
            $user->setArchivage(true);
        }
        $this->_entityManager->flush();
    }

}
