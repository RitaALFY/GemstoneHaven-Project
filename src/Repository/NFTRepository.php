<?php

namespace App\Repository;

use App\Entity\NFT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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
    /**
     * @throws NonUniqueResultException
     */
    public function findFullOneBy(string $slug): ?NFT {
        return $this->createQueryBuilder('nft')
            ->where('nft.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    public function findByRelatedCategory(NFT $nft, ?int $limit =null):array
//    {
//        return $this->createQueryBuilder('nft')
//            ->select('nft')
//            ->join('nft.subcategories', 's')
//            ->where('s IN (:subcategories)')
//            ->setParameter('subcategories', $nft->getSubCategory())
//            ->andWhere('nft != :currentNFT')
//            ->setParameter('currentNFT', $nft)
//            ->groupBy('nft')
//            ->orderBy('COUNT(s)', 'DESC')
//            ->setMaxResults($limit)
////            ->distinct(true) // Permet de bien prendre en compte la limite et d'ignorer le nombre instances
//            ->getQuery()
//            ->getResult();
//    }



}