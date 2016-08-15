<?php

namespace CodelyTV\FinderKata\Domain\Service\PersonsPair;

use CodelyTV\FinderKata\Algorithm\Person;
use CodelyTV\FinderKata\Algorithm\PersonsPair;

interface PersonsPairer
{
    /**
     * Returns an array of PersonsPair based on a criteria.
     *
     * @param Person[] $allPersons
     *
     * @return PersonsPair[]
     */
    public function __invoke(array $allPersons): array;
}
