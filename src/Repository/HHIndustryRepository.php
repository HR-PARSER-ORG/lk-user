<?php

namespace App\Repository;

use App\Entity\HHIndustry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HHIndustry>
 *
 * @method HHIndustry|null find($id, $lockMode = null, $lockVersion = null)
 * @method HHIndustry|null findOneBy(array $criteria, array $orderBy = null)
 * @method HHIndustry[]    findAll()
 * @method HHIndustry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HHIndustryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HHIndustry::class);
    }

    public function deleteAll(): int
    {
        $emptyRsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $sql = 'TRUNCATE TABLE hhindustry CASCADE';
        $query = $this->getEntityManager()->createNativeQuery($sql, $emptyRsm);
        $query->execute();
        $query->free();

        return 1;
    }
    public function add(HHIndustry $industry)
    {
        $this->getEntityManager()->persist($industry);
        $this->getEntityManager()->flush();
    }
}
