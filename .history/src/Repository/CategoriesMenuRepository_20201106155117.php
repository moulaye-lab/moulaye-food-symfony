<?php

namespace App\Repository;

use App\Entity\CategoriesMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriesMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriesMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriesMenu[]    findAll()
 * @method CategoriesMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriesMenu::class);
    }

    public function findByUser($user)
    {

        
        return $this->createQueryBuilder('r')
            ->Where('r.id_user = :user')
            ->setParameter('user', $user)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return CategoriesMenu[] Returns an array of CategoriesMenu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoriesMenu
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
