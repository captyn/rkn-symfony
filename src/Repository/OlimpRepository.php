<?php

namespace App\Repository;

use App\Entity\Olimp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Olimp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Olimp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Olimp[]    findAll()
 * @method Olimp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OlimpRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Olimp::class);
    }

//    /**
//     * @return Olimp[] Returns an array of Olimp objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Olimp
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
