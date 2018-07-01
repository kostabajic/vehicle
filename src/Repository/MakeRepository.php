<?php

namespace App\Repository;

use App\Entity\Make;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Make|null find($id, $lockMode = null, $lockVersion = null)
 * @method Make|null findOneBy(array $criteria, array $orderBy = null)
 * @method Make[]    findAll()
 * @method Make[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MakeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Make::class);
    }
    public function findByVehicleType($value)
    {
        return $this->createQueryBuilder('m')
            ->where('m.vehicle_type = :value')->setParameter('value', $value)
            ->orderBy('m.code', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
