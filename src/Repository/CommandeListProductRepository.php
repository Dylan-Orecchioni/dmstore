<?php

namespace App\Repository;

use App\Entity\CommandeListProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommandeListProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeListProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeListProduct[]    findAll()
 * @method CommandeListProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeListProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeListProduct::class);
    }

    // /**
    //  * @return CommandeListProduct[] Returns an array of CommandeListProduct objects
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
    public function findOneBySomeField($value): ?CommandeListProduct
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
