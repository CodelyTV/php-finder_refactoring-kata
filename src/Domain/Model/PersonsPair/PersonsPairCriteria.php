<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Domain\Model\PersonsPair;

use CodelyTV\FinderKata\Algorithm\PersonsPair;

interface PersonsPairCriteria
{
    /**
     * Determines if the $candidatePersonsPair has more priority than the $basePersonsPair based on a priority criteria.
     *
     * @param PersonsPair $basePersonsPair
     * @param PersonsPair $candidatePersonsPair
     *
     * @return bool
     */
    public function hasMorePriority(
        PersonsPair $basePersonsPair,
        PersonsPair $candidatePersonsPair
    ): bool;
}
