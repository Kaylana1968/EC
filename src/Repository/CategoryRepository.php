<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

       /**
        * @return Category[] Returns an array of Category objects
        */
       public function findAll(): array
       {
           return $this->createQueryBuilder('c')
               ->orderBy('c.id', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }

       public function findOneById($value): ?Category
       {
           return $this->createQueryBuilder('c')
               ->andWhere('c.id = :id')
               ->setParameter('id', $value)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }
}
