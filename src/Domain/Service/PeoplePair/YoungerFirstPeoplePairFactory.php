<?php

namespace CodelyTV\FinderKata\Domain\Service\PeoplePair;

use CodelyTV\FinderKata\Domain\Model\Person;
use CodelyTV\FinderKata\Domain\Model\PeoplePair;

final class YoungerFirstPeoplePairFactory implements PeoplePairFactory
{
    public function __invoke(Person $person1, Person $person2): PeoplePair
    {
        if ($person1->birthDate() < $person2->birthDate()) {
            return new PeoplePair($person1, $person2);
        } else {
            return new PeoplePair($person2, $person1);
        }
    }
}
