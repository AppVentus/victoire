<?php

namespace Victoire\Bundle\AnalyticsBundle\Repository;

/**
 * BrowseEventRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BrowseEventRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * return a qb ordered by visits number descending for some viewReferences[].
     *
     * @return QueryBuilder
     **/
    public function getMostVisitedFromReferences(array $referencesIds, $maxNumber = 10)
    {
        return $this->createQueryBuilder('be')
            ->select('be, COUNT(be.viewReferenceId) AS HIDDEN visits')
            ->groupBy('be.viewReferenceId')
            ->andWhere('be.viewReferenceId in (:ids)')
            ->setParameter('ids', $referencesIds)
            ->setMaxResults($maxNumber)
            ->orderBy('visits', 'DESC');
    }

    /**
     * return a qb for number of results for a viewReferenceId group by ip.
     *
     * @return QueryBuilder
     **/
    public function getNumberOfEventForViewReferenceId($referencesId)
    {
        return $this->createQueryBuilder('be')
            ->select('COUNT(DISTINCT be.ip)')
            ->andWhere('be.viewReferenceId in (:ids)')
            ->setParameter('ids', [$referencesId]);
    }
}
