<?php

namespace App\Repository;

use App\Entity\TRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TRole>
 *
 * @method TRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method TRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method TRole[]    findAll()
 * @method TRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TRole::class);
    }

    //    /**
    //     * @return TRole[] Returns an array of TRole objects
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

    //    public function findOneBySomeField($value): ?TRole
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
