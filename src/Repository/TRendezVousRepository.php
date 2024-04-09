<?php

namespace App\Repository;

use App\Entity\TRendezVous;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TRendezVous>
 *
 * @method TRendezVous|null find($id, $lockMode = null, $lockVersion = null)
 * @method TRendezVous|null findOneBy(array $criteria, array $orderBy = null)
 * @method TRendezVous[]    findAll()
 * @method TRendezVous[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TRendezVousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TRendezVous::class);
    }

    //    /**
    //     * @return TRendezVous[] Returns an array of TRendezVous objects
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

    //    public function findOneBySomeField($value): ?TRendezVous
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
