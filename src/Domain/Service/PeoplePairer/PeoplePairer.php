<?php

namespace CodelyTV\FinderKata\Domain\Service\PeoplePairer;

use CodelyTV\FinderKata\Domain\Model\Person;
use CodelyTV\FinderKata\Domain\Model\PeoplePair;

interface PeoplePairer
{
    /**
     * Returns an array of PeoplePair based on a criteria.
     *
     * @param Person[] $allPeople
     *
     * @return PeoplePair[]
     */
    public function __invoke(array $allPeople): array;
}
