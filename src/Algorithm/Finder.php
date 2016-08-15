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

    public function find(int $finderCriteria): PersonsPair
    {
        /** @var PersonsPair[] $allPersonsPairs */
        $allPersonsPairs = [];

        $numberOfPersons = count($this->allPersons);

        for ($i = 0; $i < $numberOfPersons; $i++) {
            for ($j = $i + 1; $j < $numberOfPersons; $j++) {
                $personsPair = new PersonsPair();

                if ($this->allPersons[$i]->birthDate
                    < $this->allPersons[$j]->birthDate
                ) {
                    $personsPair->person1 = $this->allPersons[$i];
                    $personsPair->person2 = $this->allPersons[$j];
                } else {
                    $personsPair->person1 = $this->allPersons[$j];
                    $personsPair->person2 = $this->allPersons[$i];
                }

                $personsPair->birthDaysDistanceInSeconds =
                    $personsPair->person2->birthDate->getTimestamp()
                    - $personsPair->person1->birthDate->getTimestamp();

                $allPersonsPairs[] = $personsPair;
            }
        }

        $thereAreNoPersonsPairs = count($allPersonsPairs) < 1;
        if ($thereAreNoPersonsPairs) {
            return new PersonsPair();
        }

        $personsPairMatchingCriteria = $allPersonsPairs[0];

        foreach ($allPersonsPairs as $personsPair) {
            switch ($finderCriteria) {
                case FinderCriteria::CLOSEST_BIRTHDAYS:
                    if ($personsPair->birthDaysDistanceInSeconds
                        < $personsPairMatchingCriteria->birthDaysDistanceInSeconds
                    ) {
                        $personsPairMatchingCriteria = $personsPair;
                    }
                    break;

                case FinderCriteria::FURTHEST_BIRTHDAYS:
                    if ($personsPair->birthDaysDistanceInSeconds
                        > $personsPairMatchingCriteria->birthDaysDistanceInSeconds
                    ) {
                        $personsPairMatchingCriteria = $personsPair;
                    }
                    break;
            }
        }

        return $personsPairMatchingCriteria;
    }
}
