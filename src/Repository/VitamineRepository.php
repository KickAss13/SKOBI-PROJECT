<?php

namespace App\Repository;

use App\Entity\Vitamine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Vitamine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vitamine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vitamine[]    findAll()
 * @method Vitamine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VitamineRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vitamine::class);
    }

    // /**
    //  * @return Vitamine[] Returns an array of Vitamine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vitamine
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
