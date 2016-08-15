<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

use CodelyTV\FinderKata\Domain\Model\PersonsPair\PersonsPairCriteria;

final class Finder
{
    /**
     * @param Person[]            $allPersons
     * @param PersonsPairCriteria $finderCriteria
     *
     * @return PersonsPair The pair of persons matching the specified
     *                     $finderCriteria
     */
    public function find(
        array $allPersons,
        PersonsPairCriteria $finderCriteria
    ): PersonsPair
    {
        $allPersonsPairs = $this->pairAllPersons($allPersons);

        $this->validateThereAreEnoughPersonsPairs($allPersonsPairs);

        $personsPairMatchingCriteria = $this->findPersonsPairMatchingCriteria(
            $finderCriteria,
            $allPersonsPairs
        );

        return $personsPairMatchingCriteria;
    }

    /**
     * @param Person[] $allPersons
     *
     * @return PersonsPair[]
     */
    private function pairAllPersons(array $allPersons): array
    {
        $allPersonsPairs = [];

        $numberOfPersons = count($allPersons);

        for ($currentPersonIteration = 0;
            $currentPersonIteration < $numberOfPersons;
            $currentPersonIteration++) {
            for ($personToPairIteration = $currentPersonIteration + 1;
                $personToPairIteration < $numberOfPersons;
                $personToPairIteration++) {

                $currentPerson = $allPersons[$currentPersonIteration];
                $personToPair  = $allPersons[$personToPairIteration];

                if ($currentPerson->birthDate() < $personToPair->birthDate()) {
                    $allPersonsPairs[] =
                        new PersonsPair($currentPerson, $personToPair);
                } else {
                    $allPersonsPairs[] =
                        new PersonsPair($personToPair, $currentPerson);
                }
            }
        }

        return $allPersonsPairs;
    }

    /**
     * @param PersonsPair[] $allPersonsPairs
     *
     * @return void
     *
     * @throws NotEnoughPersonsException
     */
    private function validateThereAreEnoughPersonsPairs(array $allPersonsPairs)
    {
        $thereAreNoPersonsPairs = count($allPersonsPairs) < 1;
        if ($thereAreNoPersonsPairs) {
            throw new NotEnoughPersonsException();
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
