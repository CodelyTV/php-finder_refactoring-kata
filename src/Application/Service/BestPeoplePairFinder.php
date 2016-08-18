<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Application\Service;

use CodelyTV\FinderKata\Domain\Model\People;
use CodelyTV\FinderKata\Domain\Model\PeoplePair;
use CodelyTV\FinderKata\Domain\Model\PeoplePairCriterion\PeoplePairCriterion;
use CodelyTV\FinderKata\Domain\Model\PeoplePairs;
use CodelyTV\FinderKata\Domain\Service\PeoplePairer\PeoplePairer;

final class BestPeoplePairFinder
{
    private $peoplePairer;

    public function __construct(PeoplePairer $aPeoplePairer)
    {
        $this->peoplePairer = $aPeoplePairer;
    }

    /** @throws NotEnoughPeopleException */
    public function __invoke(
        People $allPeople,
        PeoplePairCriterion $peoplePairCriterion
    ): PeoplePair
    {
        $allPeoplePairs = $this->peoplePairer->__invoke($allPeople);

        $this->validateThereAreEnoughPeoplePairs($allPeoplePairs);

        $peoplePairMatchingCriteria = $this->findPeoplePairMatchingCriteria(
            $peoplePairCriterion,
            $allPeoplePairs
        );

        return $peoplePairMatchingCriteria;
    }

    private function validateThereAreEnoughPeoplePairs(PeoplePairs $allPeoplePairs)
    {
        $thereAreNoPeoplePairs = count($allPeoplePairs) < 1;
        if ($thereAreNoPeoplePairs) {
            throw new NotEnoughPeopleException();
        }
    }

    private function findPeoplePairMatchingCriteria(
        PeoplePairCriterion $peoplePairCriterion,
        PeoplePairs $peoplePairs
    ): PeoplePair
    {
        $allPeoplePairs = $peoplePairs->all();

        $bestPeoplePair = $allPeoplePairs[0];

        foreach ($allPeoplePairs as $peoplePairCandidate) {
            if ($peoplePairCriterion->hasMorePriority(
                $bestPeoplePair,
                $peoplePairCandidate
            )
            ) {
                $bestPeoplePair = $peoplePairCandidate;
            }
        }

        return $bestPeoplePair;
    }
}
