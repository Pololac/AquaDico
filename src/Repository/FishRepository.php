<?php

namespace App\Repository;

use App\Entity\Fish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fish>
 */
class FishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fish::class);
    }

   public function findBySearchQuery(string $query)
   {
        return $this->createQueryBuilder('f')
        ->andWhere('f.name LIKE :query')
        ->setParameter('query', '%' . $query . '%')
        // ->orderBy('f.id', 'ASC')
        // ->setMaxResults(10)
        ->getQuery()
        ->getResult()
        ;

   }

//    public function findOneBySomeField($value): ?Fish
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
