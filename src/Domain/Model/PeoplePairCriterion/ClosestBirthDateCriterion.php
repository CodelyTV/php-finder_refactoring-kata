<?php

namespace CodelyTV\FinderKata\Domain\Model\PeoplePairCriterion;

use CodelyTV\FinderKata\Domain\Model\PeoplePair;

final class ClosestBirthDateCriterion implements PeoplePairCriterion
{
    public function hasMorePriority(
        PeoplePair $basePeoplePair,
        PeoplePair $candidatePeoplePair
    ): bool
    {
        return $candidatePeoplePair->birthDaysDistanceInSeconds()
        < $basePeoplePair->birthDaysDistanceInSeconds();
    }
}
