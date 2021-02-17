<?php

namespace App\Repository;

use App\Entity\PlatMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlatMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlatMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlatMenu[]    findAll()
 * @method PlatMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlatMenu::class);
    }

    // /**
    //  * @return PlatMenu[] Returns an array of PlatMenu objects
    //  */
  
    public function findByCatAndResto($categorie)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.categorie = :categorie')
            ->setParameter('categorie', $categorie)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
   

    /*
    public function findOneBySomeField($value): ?PlatMenu
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
