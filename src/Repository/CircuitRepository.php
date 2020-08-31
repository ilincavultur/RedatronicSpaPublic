<?php

namespace App\Repository;

use App\Entity\Circuit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Circuit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Circuit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Circuit[]    findAll()
 * @method Circuit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CircuitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Circuit::class);
    }


    public function findCircuits($search = null)
    {
        $qb = $this->createQueryBuilder('p');


        if (null !== $search){
            $qb->where('p.Rfid like :search')
                ->orWhere('p.createdAt like :search')
                ->orWhere('p.endTime like :search')
                ->setParameter('search','%'.$search.'%');
        }

        $qb->orderBy('p.createdAt','DESC');

        return $qb;
    }
     /**
      * @return Circuit[] Returns an array of Circuit objects
      */

    public function findByRfid($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Rfid = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


/*
    /**
     * @param $value
     * @return Circuit|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
/*
    public function findOneByRfid($value): ?Circuit
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Rfid = :val')
            ->andWhere('c.isOpen' == true)
            ->setParameter('val', $value)
            ->setParameter('true', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }*/

}
