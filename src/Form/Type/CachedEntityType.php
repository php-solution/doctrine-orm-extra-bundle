<?php
namespace PhpSolution\Doctrine\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This form should be used for cached entities to prevent extra call to DB
 */
class CachedEntityType extends EntityType
{
    /**
     * Return null for use repository->findAll for choices loading
     * @see \Symfony\Bridge\Doctrine\Form\ChoiceList\DoctrineChoiceLoader::loadChoiceList()
     *
     * @param ObjectManager              $manager
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param string                     $class
     *
     * @return null
     */
    public function getLoader(ObjectManager $manager, $queryBuilder, $class)
    {
        return null;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $choicesNormalizer = function(Options $options) {
            if (!is_callable($options['choices_from_repo'])) {
                return null;
            }
            $repository = $options['em']->getRepository($options['class']);

            return $options['choices_from_repo']($repository);
        };
        $resolver->setDefault('choices_from_repo', null);
        $resolver->setNormalizer('choices', $choicesNormalizer);

        parent::configureOptions($resolver);
    }
}