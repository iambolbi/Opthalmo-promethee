<?php

namespace App\Repository;

use App\Entity\TAssurance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TAssurance>
 *
 * @method TAssurance|null find($id, $lockMode = null, $lockVersion = null)
 * @method TAssurance|null findOneBy(array $criteria, array $orderBy = null)
 * @method TAssurance[]    findAll()
 * @method TAssurance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TAssuranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TAssurance::class);
    }

    //    /**
    //     * @return TAssurance[] Returns an array of TAssurance objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TAssurance
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
