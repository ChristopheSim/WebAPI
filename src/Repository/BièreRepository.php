<?php

namespace App\Repository;

use App\Entity\Bière;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bière|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bière|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bière[]    findAll()
 * @method Bière[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BièreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bière::class);
    }

//    /**
//     * @return Bière[] Returns an array of Bière objects
//     */
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
    public function findOneBySomeField($value): ?Bière
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
