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
     * @param QueryBuilder $qb
     *
     * @return QueryBuilder
     */
    public function filterQuery(QueryBuilder $qb): QueryBuilder
    {
        if (!$this->isReady()) {
            return $qb;
        }

        $filter = $this->getFilter();
        foreach ($this->getFilterRules() as $fieldName => $callable) {
            $filterValue = $this->getData($fieldName);
            if ($filterValue instanceof \Countable) {
                $filterValue = $filter->get($fieldName)->getNormData();
            }
            if (!$this->isEmptyValue($filterValue)) {
                $callable($qb, $filterValue);
            }
        }

        return $qb;
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
