<?php

namespace App\Repository;

use App\Entity\BookReadLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookReadLike>
 */
class BookReadLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookReadLike::class);
    }

   /**
    * @return BookReadLike[] Returns an array of BookReadLike objects
    */
   public function findAll(): array
   {
       return $this->createQueryBuilder('b')
           ->orderBy('b.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?BookReadLike
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
