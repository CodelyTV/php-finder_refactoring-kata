<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Domain\Model\PeoplePairCriterion;

use CodelyTV\FinderKata\Domain\Model\PeoplePair;

interface PeoplePairCriterion
{
    /**
     * Determines if the $candidatePeoplePair has more priority than the $basePeoplePair based on a priority criteria.
     *
     * @param PeoplePair $basePeoplePair
     * @param PeoplePair $candidatePeoplePair
     *
     * @return bool
     */
    public function hasMorePriority(
        PeoplePair $basePeoplePair,
        PeoplePair $candidatePeoplePair
    ): bool;
}
