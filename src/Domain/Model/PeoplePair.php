<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Domain\Model;

final class PeoplePair
{
    /** @var Person */
    private $person1;

    /** @var Person */
    private $person2;

    /** @var int */
    private $birthDaysDistanceInSeconds;

    public function __construct(Person $aPerson1, Person $aPerson2)
    {
        $this->person1                    = $aPerson1;
        $this->person2                    = $aPerson2;
        $this->birthDaysDistanceInSeconds = $this->calculateBirthDaysDistanceInSeconds();
    }

    public function person1(): Person
    {
        return $this->person1;
    }

    public function person2(): Person
    {
        return $this->person2;
    }

    public function birthDaysDistanceInSeconds(): int
    {
        return $this->birthDaysDistanceInSeconds;
    }

    private function calculateBirthDaysDistanceInSeconds(): int
    {
        return $this->person2()->birthDate()->getTimestamp() - $this->person1()->birthDate()->getTimestamp();
    }
}
