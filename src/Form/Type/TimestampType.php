<?php

namespace PhpSolution\Doctrine\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * TimestampType
 */
class TimestampType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new DateTimeToTimestampTransformer());
    }

    /**
     * @return string
     */
    public function getParent(): string
    {
        return IntegerType::class;
    }
}