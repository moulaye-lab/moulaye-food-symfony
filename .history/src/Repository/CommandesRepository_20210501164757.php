<?php

namespace App\Repository;

use App\Entity\Commandes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commandes[]    findAll()
 * @method Commandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commandes::class);
    }

    // /**
    //  * @return Commandes[] Returns an array of Commandes objects
    //  */
   
    public function findByRestaurant($restaurant)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.restaurant = :val')
            ->setParameter('val', $restaurant)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    public function findByRestoAndTable($restaurant,$table)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.restaurant = :val')
            ->andWhere('c.ta = :val')

            ->setParameter('val', $restaurant)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByTable($table)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.tableResto = :val')
            ->setParameter('val', $table)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
  

    /*
    public function findOneBySomeField($value): ?Commandes
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
