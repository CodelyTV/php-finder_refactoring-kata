<?php

namespace CodelyTV\FinderKata\Domain\Model;

use CodelyTV\Types\Collection;

class PeoplePairs extends Collection
{
    public function all() : array
    {
        return $this->items();
    }

    protected function type() : string
    {
        return PeoplePair::class;
    }
}
