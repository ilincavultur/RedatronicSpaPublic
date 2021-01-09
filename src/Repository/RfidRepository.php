<?php

namespace App\Repository;

use App\Entity\Rfid;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rfid|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rfid|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rfid[]    findAll()
 * @method Rfid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RfidRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rfid::class);
    }

    // /**
    //  * @return Rfid[] Returns an array of Rfid objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rfid
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
