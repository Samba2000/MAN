<?php

namespace App\Repository;

use App\Entity\ComminutyManger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ComminutyManger|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComminutyManger|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComminutyManger[]    findAll()
 * @method ComminutyManger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComminutyMangerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComminutyManger::class);
    }

    // /**
    //  * @return ComminutyManger[] Returns an array of ComminutyManger objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ComminutyManger
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
