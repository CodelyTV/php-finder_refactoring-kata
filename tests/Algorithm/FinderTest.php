<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKataTest\Algorithm;

use CodelyTV\FinderKata\Algorithm\Finder;
use CodelyTV\FinderKata\Algorithm\NotEnoughPersonsException;
use CodelyTV\FinderKata\Algorithm\Person;
use CodelyTV\FinderKata\Domain\Model\PersonsPair\ClosestBirthDateCriteria;
use CodelyTV\FinderKata\Domain\Model\PersonsPair\FurthestBirthDateCriteria;
use CodelyTV\FinderKata\Domain\Model\PersonsPair\PersonsPairCriteria;
use CodelyTV\FinderKata\Domain\Service\PersonsPair\PersonsPairer;
use CodelyTV\FinderKata\Domain\Service\PersonsPair\SequentialPersonsPairer;
use CodelyTV\FinderKata\Domain\Service\PersonsPair\YoungerFirstPersonsPairFactory;
use PHPUnit\Framework\TestCase;

final class FinderTest extends TestCase
{
    /** @var Person */
    private $sue;

    /** @var Person */
    private $greg;

    /** @var Person */
    private $sarah;

    /** @var Person */
    private $mike;

    protected function setUp()
    {
        $this->sue   = new Person("Sue", new \DateTime("1950-01-01"));
        $this->greg  = new Person("Greg", new \DateTime("1952-05-01"));
        $this->sarah = new Person("Sarah", new \DateTime("1982-01-01"));
        $this->mike  = new Person("Mike", new \DateTime("1979-01-01"));
    }

    /** @var PersonsPairer */
    private $personsPairer;

    /** @var Person[] */
    private $allPersons;

    /** @var PersonsPairCriteria */
    private $personsPairsCriteria;

    public function tearDown()
    {
        parent::tearDown();

        $this->personsPairer = null;
        $this->allPersons = null;
    }

    /** @test */
    public function should_throw_not_enough_persons_exception_when_given_empty_list(
    )
    {
        $this->havingAPersonsPairer();

        $this->givenAnEmptySetOfPersons();
        $this->givenAClosestBirthDateCriteria();

        $this->thenItShouldThrowANotEnoughPersonsException();

        $this->whenFinderIsCalled();
    }

    /** @test */
    public function should_throw_not_enough_persons_when_given_one_person()
    {
        $this->havingAPersonsPairer();

        $this->givenASetWithOnePerson();
        $this->givenAClosestBirthDateCriteria();

        $this->thenItShouldThrowANotEnoughPersonsException();

        $this->whenFinderIsCalled();
    }

    /** @test */
    public function should_return_closest_two_for_two_people()
    {
        $youngerFirstPersonsPairFactory = new YoungerFirstPersonsPairFactory();
        $sequentialPersonsPairer        =
            new SequentialPersonsPairer($youngerFirstPersonsPairFactory);
        $finder                         = new Finder($sequentialPersonsPairer);

        $allPersons = [$this->sue, $this->greg];

        $closestBirthDatePersonsPairsCriteria = new ClosestBirthDateCriteria();

        $personsPairFound =
            $finder->find($allPersons, $closestBirthDatePersonsPairsCriteria);

        $this->assertEquals($this->sue, $personsPairFound->person1());
        $this->assertEquals($this->greg, $personsPairFound->person2());
    }

    /** @test */
    public function should_return_furthest_two_for_two_people()
    {
        $youngerFirstPersonsPairFactory = new YoungerFirstPersonsPairFactory();
        $sequentialPersonsPairer        =
            new SequentialPersonsPairer($youngerFirstPersonsPairFactory);
        $finder                         = new Finder($sequentialPersonsPairer);

        $allPersons = [$this->mike, $this->greg];

        $furthestBirthDatePersonsPairsCriteria =
            new FurthestBirthDateCriteria();

        $personsPairFound =
            $finder->find($allPersons, $furthestBirthDatePersonsPairsCriteria);

        $this->assertEquals($this->greg, $personsPairFound->person1());
        $this->assertEquals($this->mike, $personsPairFound->person2());
    }

    /** @test */
    public function should_return_furthest_two_for_four_people()
    {
        $youngerFirstPersonsPairFactory = new YoungerFirstPersonsPairFactory();
        $sequentialPersonsPairer        =
            new SequentialPersonsPairer($youngerFirstPersonsPairFactory);
        $finder                         = new Finder($sequentialPersonsPairer);

        $allPersons = [$this->sue, $this->sarah, $this->mike, $this->greg];

        $furthestBirthDatePersonsPairsCriteria =
            new FurthestBirthDateCriteria();

        $personsPairFound =
            $finder->find($allPersons, $furthestBirthDatePersonsPairsCriteria);

        $this->assertEquals($this->sue, $personsPairFound->person1());
        $this->assertEquals($this->sarah, $personsPairFound->person2());
    }

    /** @test */
    public function should_return_closest_two_for_four_people()
    {
        $youngerFirstPersonsPairFactory = new YoungerFirstPersonsPairFactory();
        $sequentialPersonsPairer        =
            new SequentialPersonsPairer($youngerFirstPersonsPairFactory);
        $finder                         = new Finder($sequentialPersonsPairer);

        $allPersons = [$this->sue, $this->sarah, $this->mike, $this->greg];

        $closestBirthDatePersonsPairsCriteria = new ClosestBirthDateCriteria();

        $personsPairFound =
            $finder->find($allPersons, $closestBirthDatePersonsPairsCriteria);

        $this->assertEquals($this->sue, $personsPairFound->person1());
        $this->assertEquals($this->greg, $personsPairFound->person2());
    }

    /*
     * Havings
     */

    private function havingAPersonsPairer()
    {
        $this->personsPairer = $this->createMock(PersonsPairer::class);
    }

    /*
     * Given
     */

    private function givenAnEmptySetOfPersons()
    {
        $this->allPersons = [];
    }

    private function givenASetWithOnePerson()
    {
        $this->allPersons = [$this->sue];
    }

    private function givenAClosestBirthDateCriteria()
    {
        $this->personsPairsCriteria = new ClosestBirthDateCriteria();
    }

    /*
     * Thens
     */

    private function thenItShouldThrowANotEnoughPersonsException()
    {
        $this->expectException(NotEnoughPersonsException::class);
    }

    /*
     * Whens
     */

    private function whenFinderIsCalled()
    {
        $finder = new Finder($this->personsPairer);

        $finder->find($this->allPersons, $this->personsPairsCriteria);
    }
}
