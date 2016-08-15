<?php

namespace CodelyTV\FinderKata\Domain\Service\PersonsPair;

final class SequentialPersonsPairer implements PersonsPairer
{
    /** @var PersonsPairFactory */
    private $personsPairFactory;

    public function __construct(PersonsPairFactory $aPersonsPairFactory)
    {
        $this->personsPairFactory = $aPersonsPairFactory;
    }

    public function pair(array $allPersons): array
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

                $allPersonsPairs[] = $this->personsPairFactory->__invoke(
                    $currentPerson,
                    $personToPair
                );
            }
        }

        return $allPersonsPairs;
    }
}
