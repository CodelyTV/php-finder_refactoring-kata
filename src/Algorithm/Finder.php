<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

final class Finder
{
    /** @var Person[] */
    private $allPersons;

    public function __construct(array $allPersons)
    {
        $this->allPersons = $allPersons;
    }

    /**
     * @param FinderCriteria $finderCriteria
     *
     * @return PersonsPair The pair of persons matching the specified
     *                     $finderCriteria
     *
     * @throws NotEnoughPersonsException
     */
    public function find(FinderCriteria $finderCriteria): PersonsPair
    {
        $allPersonsPairs = $this->pairAllPersons($this->allPersons);

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

                $currentPerson = $this->allPersons[$currentPersonIteration];
                $personToPair  = $this->allPersons[$personToPairIteration];

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
     * @param FinderCriteria $finderCriteria
     * @param PersonsPair[]  $allPersonsPairs
     *
     * @return PersonsPair
     */
    private function findPersonsPairMatchingCriteria(
        FinderCriteria $finderCriteria,
        array $allPersonsPairs
    ): PersonsPair
    {
        $personsPairMatchingCriteria = $allPersonsPairs[0];

        foreach ($allPersonsPairs as $personsPair) {
            if ($finderCriteria->isByClosestBirthDates()) {
                if ($personsPair->birthDaysDistanceInSeconds()
                    < $personsPairMatchingCriteria->birthDaysDistanceInSeconds()
                ) {
                    $personsPairMatchingCriteria = $personsPair;
                }
            } elseif ($finderCriteria->isByFurthestBirthDates()) {
                if ($personsPair->birthDaysDistanceInSeconds()
                    > $personsPairMatchingCriteria->birthDaysDistanceInSeconds()
                ) {
                    $personsPairMatchingCriteria = $personsPair;
                }
            }
        }

        return $personsPairMatchingCriteria;
    }
}
