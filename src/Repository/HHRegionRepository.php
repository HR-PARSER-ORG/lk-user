<?php

namespace App\Repository;

use App\Entity\HHRegion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HHRegion>
 *
 * @method HHRegion|null find($id, $lockMode = null, $lockVersion = null)
 * @method HHRegion|null findOneBy(array $criteria, array $orderBy = null)
 * @method HHRegion[]    findAll()
 * @method HHRegion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HHRegionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HHRegion::class);
    }

    /**
     * Добавляет новый объект HHRegion в репозиторий.
     *
     * @param HHRegion $region
     */
    public function add(HHRegion $region): void
    {
        $this->_em->persist($region);
        $this->_em->flush();
    }
}
