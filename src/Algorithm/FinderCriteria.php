<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

final class FinderCriteria
{
    const CLOSEST_BIRTH_DATES = 1;
    const FURTHEST_BIRTH_DATES = 2;

    const VALID_FINDER_CRITERIA = [
        self::CLOSEST_BIRTH_DATES,
        self::FURTHEST_BIRTH_DATES
    ];

    private $rawFinderCriteria;

    private function __construct(int $aRawFinderCriteria)
    {
        if (!in_array($aRawFinderCriteria, self::VALID_FINDER_CRITERIA, true)) {
            throw new \InvalidArgumentException(
                "You have specified an invalid finder criteria value: <$aRawFinderCriteria>"
            );
        }

        $this->rawFinderCriteria = $aRawFinderCriteria;
    }

    public static function closestBirthDates()
    {
        return new self(self::CLOSEST_BIRTH_DATES);
    }

    public static function furthestBirthDates()
    {
        return new self(self::FURTHEST_BIRTH_DATES);
    }

    public function isByClosestBirthDates()
    {
        return $this->rawFinderCriteria === self::CLOSEST_BIRTH_DATES;
    }

    public function isByFurthestBirthDates()
    {
        return $this->rawFinderCriteria === self::FURTHEST_BIRTH_DATES;
    }
}
