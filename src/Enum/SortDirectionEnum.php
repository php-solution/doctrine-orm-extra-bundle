<?php

namespace PhpSolution\Doctrine\Enum;

use PhpSolution\StdLib\Enum\AbstractEnum;

/**
 * SortDirectionEnum
 */
class SortDirectionEnum extends AbstractEnum
{
    const ASC = 'ASC';
    const DESC = 'DESC';

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $synonyms = self::getSynonyms();
        if (array_key_exists($value, $synonyms)) {
            $value = $synonyms[$value];
        }
        $value = strtoupper($value);

        parent::__construct($value);
    }

    /**
     * @return array
     */
    protected function getAllowedValues(): array
    {
        return [self::ASC, self::DESC];
    }

    /**
     * @return array
     */
    private function getSynonyms(): array
    {
        return [
            1  => self::ASC,
            -1 => self::DESC
        ];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}