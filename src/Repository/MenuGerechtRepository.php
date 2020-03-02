<?php

namespace App\Repository;

use App\Entity\MenuGerecht;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MenuGerecht|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuGerecht|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuGerecht[]    findAll()
 * @method MenuGerecht[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuGerechtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuGerecht::class);
    }

    // /**
    //  * @return MenuGerecht[] Returns an array of MenuGerecht objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MenuGerecht
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
