<?php

namespace App\Repository;

use App\Entity\Tables;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tables|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tables|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tables[]    findAll()
 * @method Tables[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TablesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tables::class);
    }

    // /**
    //  * @return Tables[] Returns an array of Tables objects
    //  */
   
    public function findAll()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }


    
   

    /*
    public function findOneBySomeField($value): ?Tables
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
