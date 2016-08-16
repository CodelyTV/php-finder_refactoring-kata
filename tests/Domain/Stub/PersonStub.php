<?php

namespace CodelyTV\FinderKataTest\Domain\Stub;

use CodelyTV\FinderKata\Domain\Model\Person;

final class PersonStub
{
    public static function from1950()
    {
        return new Person("Sue", new \DateTime("1950-01-01"));
    }

    public static function from1952()
    {
        return new Person("Greg", new \DateTime("1952-05-01"));
    }

    public static function from1982()
    {
        return new Person("Sarah", new \DateTime("1982-01-01"));
    }

    public static function from1979()
    {
        return new Person("Mike", new \DateTime("1979-01-01"));
    }
}
