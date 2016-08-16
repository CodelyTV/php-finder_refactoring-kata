<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Domain\Model;

use DateTime;

final class Person
{
    /** @var string */
    private $name;

    /** @var DateTime */
    private $birthDate;

    public function __construct(string $aName, DateTime $aBirthDate)
    {
        $this->name      = $aName;
        $this->birthDate = $aBirthDate;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function birthDate(): DateTime
    {
        return $this->birthDate;
    }
}
