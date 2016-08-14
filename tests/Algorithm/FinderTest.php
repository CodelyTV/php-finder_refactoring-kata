<?php

namespace CodelyTV\FinderKataTest\Algorithm;

use CodelyTV\FinderKata\Algorithm\Finder;
use PHPUnit\Framework\TestCase;

final class FinderTest extends TestCase
{
    /** @test */
    public function should_be_able_to_instantiate()
    {
        $finder = new Finder();

        $this->assertInstanceOf(Finder::class, $finder);
    }
}
