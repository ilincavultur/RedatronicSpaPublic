<?php

namespace App\Repository;

use App\Entity\Membership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Membership|null find($id, $lockMode = null, $lockVersion = null)
 * @method Membership|null findOneBy(array $criteria, array $orderBy = null)
 * @method Membership[]    findAll()
 * @method Membership[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembershipRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membership::class);
    }

    /**
     * @param null $search
     * @return QueryBuilder
     */
    public function findMemberships($search = null)
    {
        $qb = $this->createQueryBuilder('p');


        if (null !== $search){
            $qb->where('p.ClientName like :search')
                ->orWhere('p.availability like :search')
                ->orWhere('p.Package like :search')
                ->orWhere('p.Age like :search')
                ->orWhere('p.NoOfEntries like :search')
                ->orWhere('p.RFID like :search')
                ->setParameter('search','%'.$search.'%');
        }

        $qb->orderBy('p.createdAt','DESC');

        return $qb;
    }

    // /**
    //  * @return Membership[] Returns an array of Membership objects
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
    public function findOneBySomeField($value): ?Membership
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
