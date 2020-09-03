<?php

namespace App\Repository;

use App\Entity\MemReception;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MemReception|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemReception|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemReception[]    findAll()
 * @method MemReception[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemReceptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemReception::class);
    }

    /**
     * @param null $search
     * @return QueryBuilder
     */
    public function findMemReceptions($search = null)
    {
        $qb = $this->createQueryBuilder('p');


        if (null !== $search){
            $qb->where('p.Membership like :search')
                ->orWhere('p.Products like :search')
                ->orWhere('p.Age like :search')
                ->orWhere('p.Rfid like :search')
                ->orWhere('p.Packages like :search')
                ->setParameter('search','%'.$search.'%');
        }

        $qb->orderBy('p.createdAt','DESC');

        return $qb;
    }

    // /**
    //  * @return MemReception[] Returns an array of MemReception objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MemReception
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
