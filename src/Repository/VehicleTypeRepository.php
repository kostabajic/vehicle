<?php

namespace App\Repository;

use App\Entity\VehicleType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VehicleType|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleType|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleType[]    findAll()
 * @method VehicleType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VehicleType::class);
    }
    
    public function findByParams($code,$description)
    {
        return $this->createQueryBuilder('m')
            ->where('m.code = :value')->setParameter('value', $code)
            ->where('m.description = :value')->setParameter('value', $description)
            ->orderBy('m.code', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}
