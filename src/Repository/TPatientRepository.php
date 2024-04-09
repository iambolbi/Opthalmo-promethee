<?php

namespace App\Repository;

use App\Entity\TPatient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TPatient>
 *
 * @method TPatient|null find($id, $lockMode = null, $lockVersion = null)
 * @method TPatient|null findOneBy(array $criteria, array $orderBy = null)
 * @method TPatient[]    findAll()
 * @method TPatient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TPatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TPatient::class);
    }

    //    /**
    //     * @return TPatient[] Returns an array of TPatient objects
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

    //    public function findOneBySomeField($value): ?TPatient
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
