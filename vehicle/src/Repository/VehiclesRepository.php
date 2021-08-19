<?php

namespace App\Repository;

use App\Entity\Vehicles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vehicles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicles[]    findAll()
 * @method Vehicles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiclesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $manager)
    {
        parent::__construct($registry, Vehicles::class);
        $this->manager = $manager;
    }

    public function saveVehicles($vehicle)
    {
        $newVehicles = new Vehicles();
        $newVehicles
            ->setVin($vehicle->vin)
            ->setColor($vehicle->color)
            ->setEnrollment($vehicle->enrollment)
            ->setCustomerId($vehicle->customerId)
            ->setModelCar($vehicle->modelCar)
            ->setStatus(true);

        $this->manager->persist($newVehicles);
        $this->manager->flush();
    }

    public function updateVehicles(Vehicles $vehicles): Vehicles
    {
        $this->manager->persist($vehicles);
        $this->manager->flush();

        return $vehicles;
    }


    public function removeVehicles(Vehicles $vehicles)
    {
        $this->manager->remove($vehicles);
        $this->manager->flush();
    }

    // /**
    //  * @return Vehicles[] Returns an array of Vehicles objects
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
    public function findOneBySomeField($value): ?Vehicles
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
