<?php

namespace CodelyTV\FinderKata\Domain\Service\PeoplePairer;

use CodelyTV\FinderKata\Domain\Service\PeoplePair\PeoplePairFactory;

final class SequentialPeoplePairer implements PeoplePairer
{
    /** @var PeoplePairFactory */
    private $peoplePairFactory;

    public function __construct(PeoplePairFactory $aPeoplePairFactory)
    {
        $this->peoplePairFactory = $aPeoplePairFactory;
    }

    public function __invoke(array $allPeople): array
    {
        $allPeoplePairs = [];

        $numberOfPeople = count($allPeople);

        for ($currentPersonIteration = 0;
            $currentPersonIteration < $numberOfPeople;
            $currentPersonIteration++) {

            for ($personToPairIteration = $currentPersonIteration + 1;
                $personToPairIteration < $numberOfPeople;
                $personToPairIteration++) {

                $currentPerson = $allPeople[$currentPersonIteration];
                $personToPair  = $allPeople[$personToPairIteration];

                $allPeoplePairs[] = $this->peoplePairFactory->__invoke(
                    $currentPerson,
                    $personToPair
                );
            }
        }

        return $allPeoplePairs;
    }
}
