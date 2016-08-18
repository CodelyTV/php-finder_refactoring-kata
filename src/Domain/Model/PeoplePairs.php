<?php

namespace CodelyTV\FinderKata\Domain\Model;

use CodelyTV\Types\Collection;

class PeoplePairs extends Collection
{
    public function all() : array
    {
        return $this->items();
    }

    public function isEmpty()
    {
        return 0 === $this->count();
    }

    protected function type() : string
    {
        return PeoplePair::class;
    }
}
