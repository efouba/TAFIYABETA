<?php

namespace App\Repository;

use App\Entity\RefreshTockens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RefreshTockens>
 *
 * @method RefreshTockens|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefreshTockens|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefreshTockens[]    findAll()
 * @method RefreshTockens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefreshTockensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshTockens::class);
    }

//    /**
//     * @return RefreshTockens[] Returns an array of RefreshTockens objects
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

//    public function findOneBySomeField($value): ?RefreshTockens
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
