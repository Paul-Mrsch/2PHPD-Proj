<?php

namespace App\Repository;

use App\Entity\OneMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OneMatch>
 *
 * @method OneMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method OneMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method OneMatch[]    findAll()
 * @method OneMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OneMatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OneMatch::class);
    }

//    /**
//     * @return OneMatch[] Returns an array of OneMatch objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OneMatch
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
