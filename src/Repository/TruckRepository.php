<?php

namespace App\Repository;

use App\Entity\Truck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Truck>
 */
class TruckRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Truck::class);
    }

    /**
     * @return Truck[] Returns an array of Truck objects
     */
    public function findByPendingStatus(): array
    {
       return $this->createQueryBuilder('t')
           ->andWhere('t.status = :val')
           ->setParameter('val', 'pending')
           ->orderBy('t.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }
      /**
     * @return Truck[] Returns an array of Truck objects
     */
    public function findByValidatedStatus(): array
    {
       return $this->createQueryBuilder('t')
           ->andWhere('t.status = :val')
           ->setParameter('val', 'validated')
           ->orderBy('t.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }
    //    /**
    //     * @return Truck[] Returns an array of Truck objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Truck
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
