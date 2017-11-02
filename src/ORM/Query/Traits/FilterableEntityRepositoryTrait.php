<?php

namespace PhpSolution\Doctrine\ORM\Query\Traits;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use PhpSolution\Doctrine\Filter\AbstractFilter;

/**
 * FilterableEntityRepositoryTrait
 */
trait FilterableEntityRepositoryTrait
{
    /**
     * @return QueryBuilder
     */
    abstract protected function getQueryBuilder(): QueryBuilder;

    /**
     * @param AbstractFilter $filter
     *
     * @return QueryBuilder
     */
    protected function getQueryBuilderByFilter(AbstractFilter $filter): QueryBuilder
    {
        $qb = $this->getQueryBuilder();
        $filter->filterQuery($qb);
        $filter->orderQuery($qb);
        $filter->limitQuery($qb);

        return $qb;
    }

    /**
     * @param AbstractFilter $filter
     *
     * @return int
     */
    public function countByFilter(AbstractFilter $filter): int
    {
        $qb = $this->getQueryBuilder();
        $filter->filterQuery($qb);

        return $qb
            ->select('COUNT(DISTINCT ' . $qb->getRootAliases()[0] . '.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param AbstractFilter $filter
     * @param int|null       $hydrationMode
     *
     * @return array
     */
    public function findByFilter(AbstractFilter $filter, $hydrationMode = AbstractQuery::HYDRATE_OBJECT): array
    {
        return $this
            ->getQueryBuilderByFilter($filter)
            ->getQuery()
            ->getResult($hydrationMode);
    }

    /**
     * @param AbstractFilter $filter
     * @param int|null       $hydrationMode
     *
     * @return mixed
     */
    public function findOneByFilter(AbstractFilter $filter, $hydrationMode = null): array
    {
        return $this
            ->getQueryBuilderByFilter($filter)
            ->getQuery()
            ->getSingleResult($hydrationMode);
    }
}
