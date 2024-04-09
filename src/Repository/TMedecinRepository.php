<?php

namespace App\Repository;

use App\Entity\TMedecin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TMedecin>
 *
 * @method TMedecin|null find($id, $lockMode = null, $lockVersion = null)
 * @method TMedecin|null findOneBy(array $criteria, array $orderBy = null)
 * @method TMedecin[]    findAll()
 * @method TMedecin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TMedecinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TMedecin::class);
    }

    //    /**
    //     * @return TMedecin[] Returns an array of TMedecin objects
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

    //    public function findOneBySomeField($value): ?TMedecin
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
