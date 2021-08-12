<?php

namespace App\Repository;

use App\Entity\SaleAnnouncement;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SaleAnnouncement|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaleAnnouncement|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaleAnnouncement[]    findAll()
 * @method SaleAnnouncement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleAnnouncementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaleAnnouncement::class);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        $qb = $this->createQueryBuilder('sA')->addSelect('a')->addSelect('c')
            ->innerJoin('sA.auto', 'a')->innerJoin('a.country', 'c')
            ->orderBy('sA.createdAt', 'DESC');
        $query = $qb->getQuery();

        return $query->execute();
    }

    /**
     * @param string|null $mark
     * @param DateTime|null $low_build_year
     * @param DateTime|null $hight_build_year
     * @param string|null $country
     * @param float|null $start_price
     * @param float|null $end_price
     * @return array
     */
    public function filter(
        ?string $mark = null,
        ?DateTime $low_build_year = null,
        ?DateTime $hight_build_year = null,
        ?string $country = null,
        ?float $start_price,
        ?float $end_price
    ): array {
        $qb = $this->createQueryBuilder('sA')->addSelect('a')->addSelect('c')
            ->innerJoin('sA.auto', 'a')->innerJoin('a.country', 'c')
            ->orderBy('sA.createdAt', 'DESC');

        if ($country) {
            $qb->andWhere('c.title = :contry')->setParameter('contry', $country);
        }

        if ($mark) {
            $qb->andWhere('a.mark = :mark')->setParameter('mark', $mark);
        }

        if ($low_build_year) {
            $qb->andWhere('a.build_year >= :low_build_year')->setParameter('low_build_year', $low_build_year);
        }

        if ($hight_build_year) {
            $qb->andWhere('a.build_year <= :hight_build_year')->setParameter('hight_build_year', $hight_build_year);
        }

        if ($start_price) {
            $qb->andWhere('sA.price >= :start_price')->setParameter('start_price', $start_price);
        }

        if ($end_price) {
            $qb->andWhere('sA.price <= :end_price')->setParameter('end_price', $end_price);
        }

        $query = $qb->getQuery();

        return $query->execute();
    }

    /**
     * @param int $id
     * @return SaleAnnouncement|null
     * @throws NonUniqueResultException
     */
    public function findById(int $id): ?SaleAnnouncement
    {
        $qb = $this->createQueryBuilder('sA')
            ->addSelect('a')
            ->addSelect('c')
            ->innerJoin('sA.auto', 'a')
            ->innerJoin('a.country', 'c')
            ->andWhere('sA.id = :id')
            ->setParameter('id', $id);
        $query = $qb->getQuery();

        return $query->getOneOrNullResult();
    }
}
