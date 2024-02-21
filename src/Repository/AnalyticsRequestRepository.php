<?php

namespace App\Repository;

use App\Entity\AnalyticsRequest;
use App\Entity\HHIndustry;
use App\Entity\HHRegion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnalyticsRequest>
 *
 * @method AnalyticsRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnalyticsRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnalyticsRequest[]    findAll()
 * @method AnalyticsRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnalyticsRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnalyticsRequest::class);
    }

    public function add(AnalyticsRequest $analyticsRequest)
    {
        $this->getEntityManager()->persist($analyticsRequest);
        $this->getEntityManager()->flush();
    }
}
