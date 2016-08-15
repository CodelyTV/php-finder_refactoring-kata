<?php

namespace CodelyTV\FinderKata\Domain\Service\PersonsPair;

use CodelyTV\FinderKata\Algorithm\Person;
use CodelyTV\FinderKata\Algorithm\PersonsPair;

final class YoungerFirstPersonsPairFactory implements PersonsPairFactory
{
    public function __invoke(Person $person1, Person $person2): PersonsPair
    {
        if ($person1->birthDate() < $person2->birthDate()) {
            return new PersonsPair($person1, $person2);
        } else {
            return new PersonsPair($person2, $person1);
        }
    }
}
