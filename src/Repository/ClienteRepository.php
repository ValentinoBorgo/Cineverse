<?php

namespace App\Repository;

use App\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cliente>
 *
 * @method Cliente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cliente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cliente[]    findAll()
 * @method Cliente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cliente::class);
    }

    public function verificarDatosRepetidos() {
        return $this->findAll();
    }

    public function encontrarNombre($nombre, $nombre_usuario, $correo_electronico): ?array
    {

        $repetidos = [];

        $clienteNombre = $this->findOneBy(['nombre' => $nombre]);
        $clienteNombre_Usuario = $this->findOneBy(['nombre_usuario' => $nombre_usuario]);
        $clienteCorreo_Electronico = $this->findOneBy(['correo_electronico' => $correo_electronico]);

        if ($clienteNombre) {
            $repetidos[] = $clienteNombre->getNombre();
        }elseif($clienteNombre_Usuario){
            $repetidos[] = $clienteNombre_Usuario->getnombre_usuario();
        }elseif($clienteCorreo_Electronico){
            $repetidos[] = $clienteCorreo_Electronico->getcorreo_electronico();
        }

        return $repetidos;

    }

}

//    /**
//     * @return Cliente[] Returns an array of Cliente objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cliente
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

