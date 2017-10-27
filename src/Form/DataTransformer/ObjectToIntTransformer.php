<?php

namespace PhpSolution\Doctrine\Form\DataTransformer;

use PhpSolution\StdLib\Helper\Helper;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * ObjectToIntTransformer
 */
class ObjectToIntTransformer implements DataTransformerInterface
{
    /**
     * @var string
     */
    private $class;
    /**
     * @var string
     */
    private $getter;

    /**
     * @param string      $class
     * @param string|null $getter
     */
    public function __construct(string $class, string $getter = null)
    {
        $this->class = $class;
        $this->getter = null === $getter ? 'getValue' : $getter;
    }

    /**
     * @param object $object
     *
     * @return int|null
     * @throws TransformationFailedException
     */
    public function transform($object):? int
    {
        if (null === $object) {
            return null;
        }
        if (!$object instanceof $this->class) {
            throw new TransformationFailedException(sprintf('Was expected instance of "%s", but got "%s"', $this->class, Helper::getType($object)));
        }

        return $object->{$this->getter}();
    }

    /**
     * @param int|null $int
     *
     * @return null|object
     */
    public function reverseTransform($int)
    {
        try {
            return null === $int ? null : new $this->class($int);
        } catch (\RuntimeException $ex) {
            throw new TransformationFailedException($ex->getMessage());
        }
    }
}