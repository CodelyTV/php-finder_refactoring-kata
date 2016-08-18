<?php

namespace CodelyTV\FinderKata\Domain\Service\PeoplePairer;

use CodelyTV\FinderKata\Domain\Model\People;
use CodelyTV\FinderKata\Domain\Model\PeoplePairs;

interface PeoplePairer
{
    public function __invoke(People $allPeople) : PeoplePairs;
}
