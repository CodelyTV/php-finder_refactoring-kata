<?php

namespace CodelyTV\FinderKata\Domain\Service\PeoplePairer;

use CodelyTV\FinderKata\Domain\Model\People;
use CodelyTV\FinderKata\Domain\Model\PeoplePairs;
use CodelyTV\FinderKata\Domain\Service\PeoplePair\PeoplePairFactory;

final class SequentialPeoplePairer implements PeoplePairer
{
    private $peoplePairFactory;

    public function __construct(PeoplePairFactory $aPeoplePairFactory)
    {
        $this->peoplePairFactory = $aPeoplePairFactory;
    }

    public function __invoke(People $people) : PeoplePairs
    {
        $allPeople = $people->all();

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

        return new PeoplePairs($allPeoplePairs);
    }
}
