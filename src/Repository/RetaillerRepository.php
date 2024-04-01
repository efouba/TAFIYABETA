<?php

namespace App\Repository;

use App\Entity\Retailler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Retailler>
 *
 * @method Retailler|null find($id, $lockMode = null, $lockVersion = null)
 * @method Retailler|null findOneBy(array $criteria, array $orderBy = null)
 * @method Retailler[]    findAll()
 * @method Retailler[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetaillerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Retailler::class);
    }

//    /**
//     * @return Retailler[] Returns an array of Retailler objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Retailler
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
