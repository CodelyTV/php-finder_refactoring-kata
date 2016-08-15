<?php

namespace CodelyTV\FinderKata\Domain\Service\PersonsPair;

use CodelyTV\FinderKata\Algorithm\Person;
use CodelyTV\FinderKata\Algorithm\PersonsPair;

interface PersonsPairFactory
{
    public function __invoke(Person $person1, Person $person2): PersonsPair;
}
