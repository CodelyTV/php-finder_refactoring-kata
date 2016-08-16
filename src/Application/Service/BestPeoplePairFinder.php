<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Application\Service;

use CodelyTV\FinderKata\Domain\Model\Person;
use CodelyTV\FinderKata\Domain\Model\PeoplePair;
use CodelyTV\FinderKata\Domain\Model\PeoplePairCriterion\PeoplePairCriterion;
use CodelyTV\FinderKata\Domain\Service\PeoplePairer\PeoplePairer;

final class BestPeoplePairFinder
{
    /** @var PeoplePairer */
    private $peoplePairer;

    public function __construct(PeoplePairer $aPeoplePairer)
    {
        $this->peoplePairer = $aPeoplePairer;
    }

    /**
     * @param Person[]            $allPeople
     * @param PeoplePairCriterion $peoplePairCriterion
     *
     * @return PeoplePair The pair of persons matching the specified
     *                     $finderCriteria
     */
    public function __invoke(
        array $allPeople,
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

    /**
     * @param PeoplePair[] $allPeoplePairs
     *
     * @return void
     *
     * @throws NotEnoughPeopleException
     */
    private function validateThereAreEnoughPeoplePairs(array $allPeoplePairs)
    {
        $thereAreNoPeoplePairs = count($allPeoplePairs) < 1;
        if ($thereAreNoPeoplePairs) {
            throw new NotEnoughPeopleException();
        }
    }

    /**
     * @param PeoplePairCriterion $peoplePairCriterion
     * @param PeoplePair[]        $allPeoplePairs
     *
     * @return PeoplePair
     */
    private function findPeoplePairMatchingCriteria(
        PeoplePairCriterion $peoplePairCriterion,
        array $allPeoplePairs
    ): PeoplePair
    {
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
