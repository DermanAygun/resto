<?php

namespace App\Repository;

use App\Entity\Barman;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Barman|null find($id, $lockMode = null, $lockVersion = null)
 * @method Barman|null findOneBy(array $criteria, array $orderBy = null)
 * @method Barman[]    findAll()
 * @method Barman[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BarmanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Barman::class);
    }

    // /**
    //  * @return Barman[] Returns an array of Barman objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Barman
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
