<?php

namespace App\Repository;

use App\Entity\HHSubIndustry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HHSubIndustry>
 *
 * @method HHSubIndustry|null find($id, $lockMode = null, $lockVersion = null)
 * @method HHSubIndustry|null findOneBy(array $criteria, array $orderBy = null)
 * @method HHSubIndustry[]    findAll()
 * @method HHSubIndustry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HHSubIndustryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HHSubIndustry::class);
    }

    public function deleteAll(): int
    {
        $qb = $this->createQueryBuilder('t');
        $qb->delete();
        return $qb->getQuery()->getSingleScalarResult() ?? 0;
    }

    public function add(HHSubIndustry $subIndustry)
    {
        $this->getEntityManager()->persist($subIndustry);
        $this->getEntityManager()->flush();
    }
}
