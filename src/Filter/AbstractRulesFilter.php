<?php

namespace PhpSolution\Doctrine\Filter;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\QueryBuilder;

/**
 * AbstractRulesFilter
 */
abstract class AbstractRulesFilter extends AbstractFilter
{
    /**
     * @param QueryBuilder $query
     *
     * @return QueryBuilder
     */
    public function filterQuery(QueryBuilder $query)
    {
        $filter = $this->getFilter();
        foreach ($this->getFilterRules() as $fieldName => $callable) {
            $filterValue = $filter->get($fieldName)->getData();
            if ($filterValue instanceof \Countable) {
                $filterValue = $filter->get($fieldName)->getNormData();
            }
            if (!$this->isEmptyValue($filterValue)) {
                $callable($query, $filterValue);
            }
        }

        return $query;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    protected function isEmptyValue($value): bool
    {
        return $value instanceof Collection
            ? $value->isEmpty()
            : empty($value);
    }

    /**
     * @return array
     */
    protected abstract function getFilterRules(): array ;
} 
