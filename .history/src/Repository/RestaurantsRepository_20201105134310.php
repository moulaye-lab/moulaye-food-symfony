<?php

namespace App\Repository;

use App\Entity\Restaurants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurants[]    findAll()
 * @method Restaurants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurants::class);
    }

    // /**
    //  * @return Restaurants[] Returns an array of Restaurants objects
    //  */
 
    public function findByUser()
    {

        $user=$this->getUser()->getId();
        return $this->createQueryBuilder('r')
            ->andWhere('r.propietaire = :user')
            ->setParameter('user', $user)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
   

    /*
    public function findOneBySomeField($value): ?Restaurants
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
