<?php

namespace App\Repository;

use App\Entity\TLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TLog>
 *
 * @method TLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method TLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method TLog[]    findAll()
 * @method TLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TLog::class);
    }

    //    /**
    //     * @return TLog[] Returns an array of TLog objects
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

    //    public function findOneBySomeField($value): ?TLog
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
