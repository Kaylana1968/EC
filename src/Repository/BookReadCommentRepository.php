<?php

namespace App\Repository;

use App\Entity\BookReadComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookReadComment>
 */
class BookReadCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookReadComment::class);
    }

       /**
        * @return BookReadComment[] Returns an array of BookReadComment objects
        */
       public function findAll(): array
       {
           return $this->createQueryBuilder('b')
               ->orderBy('b.created_at', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?BookReadComment
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
