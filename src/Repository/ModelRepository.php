<?php

namespace App\Repository;

use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Model::class);
    }
    public function findByVehicleTypeAndMake($id_vehicle_type,$id_make)
    {
        return $this->createQueryBuilder('m')
            ->where('m.vehicle_type = :value')->setParameter('value', $id_vehicle_type)
            ->where('m.make = :value')->setParameter('value', $id_make)
            ->orderBy('m.code', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
     public function findByMake($id_make)
    {
        return $this->createQueryBuilder('m')
            ->where('m.make = :value')->setParameter('value', $id_make)
            ->orderBy('m.code', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
