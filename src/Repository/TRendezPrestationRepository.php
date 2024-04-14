<?php

namespace App\Repository;

use App\Entity\TRendezPrestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TRendezPrestation>
 *
 * @method TRendezPrestation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TRendezPrestation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TRendezPrestation[]    findAll()
 * @method TRendezPrestation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TRendezPrestationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TRendezPrestation::class);
    }

    //    /**
    //     * @return TRendezPrestation[] Returns an array of TRendezPrestation objects
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

    //    public function findOneBySomeField($value): ?TRendezPrestation
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
