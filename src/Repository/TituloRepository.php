<?php

namespace App\Repository;

use App\Entity\Titulo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Titulo>
 *
 * @method Titulo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Titulo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Titulo[]    findAll()
 * @method Titulo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TituloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Titulo::class);
    }

//    /**
//     * @return Titulo[] Returns an array of Titulo objects
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

//    public function findOneBySomeField($value): ?Titulo
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
