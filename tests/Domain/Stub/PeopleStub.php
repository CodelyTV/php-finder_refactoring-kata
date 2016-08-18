<?php

namespace CodelyTV\FinderKataTest\Domain\Stub;

use CodelyTV\FinderKata\Domain\Model\People;
use CodelyTV\FinderKata\Domain\Model\Person;

final class PeopleStub
{
    public static function create(Person ...$persons)
    {
        return new People($persons);
    }

    public static function withNoOne()
    {
        return new People([]);
    }
}
