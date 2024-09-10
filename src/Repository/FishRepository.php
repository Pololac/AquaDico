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

    public function findAllByDescendingId()
    {
        return $this->findBy([], ['id' => 'DESC']);
    }
    
   public function findBySearchQuery(string $query)
   {
        return $this->createQueryBuilder('f')
        ->andWhere('f.name LIKE :query')
        ->setParameter('query', '%' . $query . '%')
        // ->orderBy('f.id', 'ASC')
        // ->setMaxResults(10)
        ->getQuery()
        ->getResult();
   }

/**
 * @return Fish[]
 */
   public function findByFamily(string $query): array
   {
        return $this->createQueryBuilder('f')
        ->join('f.family', 'ff')
        ->where('ff.slug = :familySlug')
        ->setParameter('familySlug', $query)
        ->getQuery()
        ->getResult();

   }

/**
 * @return Fish[]
 */
   public function findByOrigin(string $query): array
   {
        return $this->createQueryBuilder('f')
        ->join('f.origin', 'o')
        ->where('o.slug = :continentSlug')
        ->setParameter('continentSlug', $query)
        ->getQuery()
        ->getResult();
   }

/**
 * @return Fish[]
 */
   public function findByFilters(array $criteria): array
   {
       $qb = $this->createQueryBuilder('f');

        // Pour sortir les poissons qui correspondent à la famille actuelle
        if (isset($criteria['family'])) {
            $qb->andWhere('f.family = :family')
            ->setParameter('family', $criteria['family']);
        }

        // Pour sortir les poissons qui correspondent à l'origine actuelle
        if (isset($criteria['origin'])) {
            $qb->andWhere('f.origin = :origin')
            ->setParameter('origin', $criteria['origin']);
        }

        // Filtrer par température
        if (isset($criteria['minTemp'])) {
            $qb->andWhere('f.minTemp >= :minTemp')
            ->setParameter('minTemp', $criteria['minTemp']);
        }

        if (isset($criteria['maxTemp'])) {
            $qb->andWhere('f.maxTemp <= :maxTemp')
            ->setParameter('maxTemp', $criteria['maxTemp']);
        }

       // Filtrer par pH
        if (isset($criteria['minPh'])) {
            $qb->andWhere('f.minPh >= :minPh')
            ->setParameter('minPh', $criteria['minPh']);
        }

        if (isset($criteria['maxPh'])) {
            $qb->andWhere('f.maxPh <= :maxPh')
            ->setParameter('maxPh', $criteria['maxPh']);
        }

       // Filtrer par GH
        if (isset($criteria['minGh'])) {
            $qb->andWhere('f.minGh >= :minGh')
            ->setParameter('minGh', $criteria['minGh']);
        }

        if (isset($criteria['maxGh'])) {
            $qb->andWhere('f.maxGh <= :maxGh')
            ->setParameter('maxGh', $criteria['maxGh']);
        }

       // Filtrer par taille adulte
        if (isset($criteria['minAdultSize'])) {
            $qb->andWhere('f.adultSize >= :minAdultSize')
            ->setParameter('minAdultSize', $criteria['minAdultSize']);
        }

        if (isset($criteria['maxAdultSize'])) {
            $qb->andWhere('f.adultSize <= :maxAdultSize')
            ->setParameter('maxAdultSize', $criteria['maxAdultSize']);
        }

       return $qb->getQuery()->getResult();
   }

    // Compter les poissons par famille
    public function countByFamily(): array
    {
        return $this->createQueryBuilder('f')
            ->select('ff.name as familyName, ff.slug as familySlug, COUNT(f.id) as fishCount')
            ->join('f.family', 'ff')
            ->groupBy('ff.id')
            ->getQuery()
            ->getResult();
    }

    // Compter les poissons par origine
    public function countByOrigin(): array
    {
        return $this->createQueryBuilder('f')
            ->select('o.continent as originName, o.slug as originSlug, COUNT(f.id) as fishCount')
            ->join('f.origin', 'o')
            ->groupBy('o.id')
            ->getQuery()
            ->getResult();
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
