<?php

namespace App\Repository;

use App\Entity\GaleryOfUser;
use App\Entity\NFT;

use App\Entity\SubCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NFT>
 *
 * @method NFT|null find($id, $lockMode = null, $lockVersion = null)
 * @method NFT|null findOneBy(array $criteria, array $orderBy = null)
 * @method NFT[]    findAll()
 * @method NFT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NFTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NFT::class);
    }

//    /**
//     * @return NFT[] Returns an array of NFT objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NFT
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findFullOneBy(string $slug) : ? NFT
    {return $this->getQbAll()
        ->where('n.slug = :slug')
        ->setParameter('slug', $slug)
        ->getQuery()
        ->getOneOrNullResult();
    }

    public function findBySub(SubCategory $sub)
    {return $this->createQueryBuilder('n')
        ->join('n.subCategory', 's')
        ->where('s = :subCategory')
        ->setParameter('subCategory', $sub)
        ->orderBy('n.dropAt', 'DESC')
        ->getQuery()
        ->getResult()
        ;
    }
    /**
     * @throws NonUniqueResultException
     */








}