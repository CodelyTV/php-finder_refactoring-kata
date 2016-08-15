<?php

namespace CodelyTV\FinderKata\Domain\Model\PersonsPair;

use CodelyTV\FinderKata\Algorithm\PersonsPair;

final class FurthestBirthDateCriteria implements PersonsPairCriteria
{
    /** @{InheritDoc} */
    public function hasMorePriority(
        PersonsPair $basePersonsPair,
        PersonsPair $candidatePersonsPair
    ): bool
    {
        return $candidatePersonsPair->birthDaysDistanceInSeconds()
        > $basePersonsPair->birthDaysDistanceInSeconds();
    }
}
