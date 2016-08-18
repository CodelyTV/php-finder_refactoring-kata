<?php

namespace CodelyTV\FinderKata\Domain\Model;

use CodelyTV\Types\Collection;

final class People extends Collection
{
    protected function type() : string
    {
        return Person::class;
    }

    public function all()
    {
        return $this->items();
    }
}
