<?php

namespace CodelyTV\FinderKata\Domain\Service\PersonsPair;

use CodelyTV\FinderKata\Algorithm\PersonsPair;

final class SequentialPersonsPairer implements PersonsPairer
{
    public function pair(array $allPersons): array {
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
}
