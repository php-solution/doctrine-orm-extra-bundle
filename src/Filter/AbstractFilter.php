<?php

namespace PhpSolution\Doctrine\Filter;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * AbstractFilter
 */
abstract class AbstractFilter
{
    /**
     * @var FormInterface
     */
    protected $filter;

    /**
     * @param FormFactory $formFactory
     * @param array       $options
     */
    public function __construct(FormFactory $formFactory, array $options = [])
    {
        $this->filter = $formFactory->create($this->getFormClass(), null, $options);
    }

    /**
     * @return FormInterface
     */
    final public function getFilter(): FormInterface
    {
        return $this->filter;
    }

    /**
     * @param Request $request
     *
     * @return self
     */
    final public function handleRequest(Request $request)
    {
        $this->filter->handleRequest($request);

        return $this;
    }

    /**
     * @param null|string|array $data
     *
     * @return self
     */
    final public function submitData($data)
    {
        $this->filter->submit($data);

        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    final public function getData(string $name, $default = null)
    {
        if (!$this->filter->isSubmitted()) {
            throw new \RuntimeException('Filter was not submitted');
        }

        return $this->filter->has($name) ? $this->filter->get($name)->getData() : $default;
    }

    /**
     * @return string
     */
    abstract function getFormClass(): string;

    /**
     * @param QueryBuilder $query
     *
     * @return QueryBuilder
     */
    abstract public function filterQuery(QueryBuilder $query);
}
