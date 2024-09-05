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

   public function findByFilters(array $criteria): array
   {
       $qb = $this->createQueryBuilder('f');

       // Filtrer par température
       if (isset($criteria['temperature'])) {
           $qb->andWhere('f.temperature BETWEEN :tempMin AND :tempMax')
              ->setParameter('tempMin', $criteria['temperature']['min'])
              ->setParameter('tempMax', $criteria['temperature']['max']);
       }

       // Filtrer par pH
       if (isset($criteria['ph'])) {
           $qb->andWhere('f.ph BETWEEN :phMin AND :phMax')
              ->setParameter('phMin', $criteria['ph']['min'])
              ->setParameter('phMax', $criteria['ph']['max']);
       }

       // Filtrer par GH
       if (isset($criteria['gh'])) {
           $qb->andWhere('f.gh BETWEEN :ghMin AND :ghMax')
              ->setParameter('ghMin', $criteria['gh']['min'])
              ->setParameter('ghMax', $criteria['gh']['max']);
       }

       // Filtrer par taille adulte
       if (isset($criteria['adultSize'])) {
           $qb->andWhere('f.adultSize BETWEEN :sizeMin AND :sizeMax')
              ->setParameter('sizeMin', $criteria['adultSize']['min'])
              ->setParameter('sizeMax', $criteria['adultSize']['max'] ?? 100); // Valeur par défaut pour '11+'
       }

       return $qb->getQuery()->getResult();
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
