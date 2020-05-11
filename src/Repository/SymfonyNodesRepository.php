<?php

namespace App\Repository;

use App\Entity\SymfonyNodes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SymfonyNodes|null find($id, $lockMode = null, $lockVersion = null)
 * @method SymfonyNodes|null findOneBy(array $criteria, array $orderBy = null)
 * @method SymfonyNodes[]    findAll()
 * @method SymfonyNodes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SymfonyNodesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SymfonyNodes::class);
    }

    // /**
    //  * @return SymfonyNodes[] Returns an array of SymfonyNode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SymfonyNode
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
