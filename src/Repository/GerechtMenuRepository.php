<?php

namespace App\Repository;

use App\Entity\GerechtMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GerechtMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method GerechtMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method GerechtMenu[]    findAll()
 * @method GerechtMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GerechtMenuRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GerechtMenu::class);
    }

    // /**
    //  * @return GerechtMenu[] Returns an array of GerechtMenu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GerechtMenu
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
