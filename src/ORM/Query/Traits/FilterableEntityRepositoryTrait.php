<?php

namespace PhpSolution\Doctrine\Query\ORM\Traits;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
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
     * @return Query
     */
    protected function getQueryByFilter(AbstractFilter $filter): Query
    {
        return $filter
            ->filterQuery($this->getQueryBuilder())
            ->getQuery();
    }

    /**
     * @param AbstractFilter $filter
     * @param int|null       $hydrationMode
     *
     * @return array
     */
    public function findByFilter(AbstractFilter $filter, $hydrationMode = AbstractQuery::HYDRATE_OBJECT): array
    {
        return $this->getQueryByFilter($filter)->getResult($hydrationMode);
    }

    /**
     * @param AbstractFilter $filter
     * @param int|null       $hydrationMode
     *
     * @return mixed
     */
    public function findOneByFilter(AbstractFilter $filter, $hydrationMode = null): array
    {
        return $this->getQueryByFilter($filter)->getSingleResult($hydrationMode);
    }
}