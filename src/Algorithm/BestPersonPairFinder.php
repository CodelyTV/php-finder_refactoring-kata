<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

use CodelyTV\FinderKata\Domain\Model\PersonsPair\PersonsPairCriteria;
use CodelyTV\FinderKata\Domain\Service\PersonsPair\PersonsPairer;

final class BestPersonPairFinder
{
    /** @var PersonsPairer */
    private $personsPairer;

    public function __construct(PersonsPairer $aPersonsPairer)
    {
        $this->personsPairer = $aPersonsPairer;
    }

    /**
     * @param Person[]            $allPersons
     * @param PersonsPairCriteria $finderCriteria
     *
     * @return PersonsPair The pair of persons matching the specified
     *                     $finderCriteria
     */
    public function __invoke(
        array $allPersons,
        PersonsPairCriteria $finderCriteria
    ): PersonsPair
    {
        $allPersonsPairs = $this->personsPairer->__invoke($allPersons);

        $this->validateThereAreEnoughPersonsPairs($allPersonsPairs);

        $personsPairMatchingCriteria = $this->findPersonsPairMatchingCriteria(
            $finderCriteria,
            $allPersonsPairs
        );

        return $personsPairMatchingCriteria;
    }

    /**
     * @param PersonsPair[] $allPersonsPairs
     *
     * @return void
     *
     * @throws NotEnoughPeopleException
     */
    private function validateThereAreEnoughPersonsPairs(array $allPersonsPairs)
    {
        $thereAreNoPersonsPairs = count($allPersonsPairs) < 1;
        if ($thereAreNoPersonsPairs) {
            throw new NotEnoughPeopleException();
        }
    }

    /**
     * @param PersonsPairCriteria $personsPairPriorityCriteria
     * @param PersonsPair[]       $allPersonsPairs
     *
     * @return PersonsPair
     */
    private function findPersonsPairMatchingCriteria(
        PersonsPairCriteria $personsPairPriorityCriteria,
        array $allPersonsPairs
    ): PersonsPair
    {
        $bestPersonsPair = $allPersonsPairs[0];

        foreach ($allPersonsPairs as $personsPairCandidate) {
            if ($personsPairPriorityCriteria->hasMorePriority(
                $bestPersonsPair,
                $personsPairCandidate
            )
            ) {
                $bestPersonsPair = $personsPairCandidate;
            }
        }

        return $bestPersonsPair;
    }
}
