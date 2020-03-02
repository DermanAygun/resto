<?php

namespace App\Repository;

use App\Entity\Klant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Klant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Klant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Klant[]    findAll()
 * @method Klant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KlantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Klant::class);
    }

    // /**
    //  * @return Klant[] Returns an array of Klant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Klant
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
