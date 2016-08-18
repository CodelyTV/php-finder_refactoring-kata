<?php

namespace CodelyTV\FinderKata\Domain\Service\PeoplePairer;

use CodelyTV\FinderKata\Domain\Model\People;
use CodelyTV\FinderKata\Domain\Model\PeoplePair;

interface PeoplePairer
{
    /**
     * Returns an array of PeoplePair based on a criteria.
     *
     * @return PeoplePair[]
     */
    public function __invoke(People $allPeople): array;
}
