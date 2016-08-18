<?php

namespace CodelyTV\FinderKata\Domain\Service\PeoplePair;

use CodelyTV\FinderKata\Domain\Model\PeoplePair;
use CodelyTV\FinderKata\Domain\Model\Person;

interface PeoplePairFactory
{
    public function __invoke(Person $person1, Person $person2): PeoplePair;
}
