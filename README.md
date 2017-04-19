# Doctrine ORM extra bundle

## Install
Via Composer
``` bash
$ composer require php-solution/doctrine-orm-extra-bundle
```

## Example
Caching of entities, **doctrine.yml**
```
doctrine_orm_extra:
    entity_cache_map:
        Project\AppBundle\Entity\Country: {usage: READ_WRITE, region: entity_region}
```