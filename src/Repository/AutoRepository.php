<?php

namespace App\Repository;

use App\Entity\Auto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Auto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auto[]    findAll()
 * @method Auto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auto::class);
    }
}
