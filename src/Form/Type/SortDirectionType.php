<?php

namespace PhpSolution\Doctrine\Form\Type;

use PhpSolution\Doctrine\Enum\SortDirectionEnum;
use PhpSolution\Doctrine\Form\DataTransformer\ObjectToIntTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * SortDirectionType
 */
class SortDirectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new ObjectToIntTransformer(SortDirectionEnum::class));
    }

    /**
     * @return string
     */
    public function getParent(): string
    {
        return TextType::class;
    }
}