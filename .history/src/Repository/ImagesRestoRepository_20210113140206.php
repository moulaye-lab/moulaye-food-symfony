<?php

namespace App\Repository;

use App\Entity\ImagesResto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImagesResto|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagesResto|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagesResto[]    findAll()
 * @method ImagesResto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagesRestoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagesResto::class);
    }

    // /**
    //  * @return ImagesResto[] Returns an array of ImagesResto objects
    //  */
    
    public function findByResto($restaurant)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.annonce = :val')
            ->setParameter('val', $restaurant) 
            ->getQuery()
            ->getResult()
        ;
    }
   

    /*
    public function findOneBySomeField($value): ?ImagesResto
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
