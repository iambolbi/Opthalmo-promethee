<?php

namespace App\Repository;

use App\Entity\TUserRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TUserRole>
 *
 * @method TUserRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method TUserRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method TUserRole[]    findAll()
 * @method TUserRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TUserRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TUserRole::class);
    }

    //    /**
    //     * @return TUserRole[] Returns an array of TUserRole objects
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

    //    public function findOneBySomeField($value): ?TUserRole
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
