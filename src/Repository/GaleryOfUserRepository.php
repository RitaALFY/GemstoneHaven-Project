<?php

namespace App\Repository;

use App\Entity\GaleryOfUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GaleryOfUser>
 *
 * @method GaleryOfUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method GaleryOfUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method GaleryOfUser[]    findAll()
 * @method GaleryOfUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GaleryOfUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GaleryOfUser::class);
    }

//    /**
//     * @return GaleryOfUser[] Returns an array of GaleryOfUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GaleryOfUser
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
