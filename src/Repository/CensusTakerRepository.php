<?php

namespace App\Repository;

use App\Entity\CensusTaker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CensusTaker>
 *
 * @method CensusTaker|null find($id, $lockMode = null, $lockVersion = null)
 * @method CensusTaker|null findOneBy(array $criteria, array $orderBy = null)
 * @method CensusTaker[]    findAll()
 * @method CensusTaker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CensusTakerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CensusTaker::class);
    }

//    /**
//     * @return CensusTaker[] Returns an array of CensusTaker objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CensusTaker
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
