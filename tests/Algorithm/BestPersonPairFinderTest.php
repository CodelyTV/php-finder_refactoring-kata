<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKataTest\Algorithm;

use CodelyTV\FinderKata\Algorithm\BestPersonPairFinder;
use CodelyTV\FinderKata\Algorithm\NotEnoughPeopleException;
use CodelyTV\FinderKata\Algorithm\Person;
use CodelyTV\FinderKata\Algorithm\PersonsPair;
use CodelyTV\FinderKata\Domain\Model\PersonsPair\ClosestBirthDateCriteria;
use CodelyTV\FinderKata\Domain\Model\PersonsPair\FurthestBirthDateCriteria;
use CodelyTV\FinderKata\Domain\Model\PersonsPair\PersonsPairCriteria;
use CodelyTV\FinderKata\Domain\Service\PersonsPair\PersonsPairer;
use CodelyTV\FinderKata\Domain\Service\PersonsPair\SequentialPersonsPairer;
use CodelyTV\FinderKata\Domain\Service\PersonsPair\YoungerFirstPersonsPairFactory;
use CodelyTV\FinderKataTest\Domain\Stub\PersonStub;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

final class BestPersonPairFinderTest extends TestCase
{
    /** @var PersonsPairer|PHPUnit_Framework_MockObject_MockObject */
    private $personsPairer;

    /** @var Person[] */
    private $allPersons;

    /** @var PersonsPairCriteria */
    private $personsPairsCriteria;

    /** @var PersonsPair */
    private $personsPairFound;

    public function tearDown()
    {
        parent::tearDown();

        $this->personsPairer        = null;
        $this->allPersons           = null;
        $this->personsPairsCriteria = null;
        $this->personsPairFound     = null;
    }

    /** @test */
    public function should_throw_not_enough_persons_exception_when_given_empty_set(
    )
    {
        $this->havingAPersonsPairer();

        $this->givenAnEmptySetOfPersons();
        $this->givenAClosestBirthDateCriteria();

        $this->thenItShouldThrowANotEnoughPeopleException();

        $this->whenFinderIsCalled();
    }

    /** @test */
    public function should_throw_not_enough_persons_exception_when_given_one_person(
    )
    {
        $this->havingAPersonsPairer();

        $this->givenASetWithOnePerson();
        $this->givenAClosestBirthDateCriteria();

        $this->thenItShouldThrowANotEnoughPeopleException();

        $this->whenFinderIsCalled();
    }

    /** @test */
    public function should_return_closest_two_for_two_people()
    {
        $this->havingASequentialPersonsPairer();

        $this->givenASetWithTwoDifferentPeople();
        $this->givenAClosestBirthDateCriteria();

        $this->whenFinderIsCalled();

        $this->thenItReturnsTheTwoGivenPeople();
    }

    /** @test */
    public function should_return_furthest_two_for_four_people()
    {
        $this->havingASequentialPersonsPairer();

        $this->givenAnUnorderedSetWithFourPeople();
        $this->givenAFurthestBirthDateCriteria();

        $this->whenFinderIsCalled();

        $this->thenItReturnsTheTwoFurthestPeople();
    }

    /** @test */
    public function should_return_closest_two_for_four_people()
    {
        $this->havingASequentialPersonsPairer();

        $this->givenAnUnorderedSetWithFourPeople();
        $this->givenAClosestBirthDateCriteria();

        $this->whenFinderIsCalled();

        $this->thenItReturnsTheTwoClosestPeople();
    }

    /*
     * Havings
     */

    private function havingAPersonsPairer()
    {
        $this->personsPairer = $this->createMock(PersonsPairer::class);
    }

    private function havingASequentialPersonsPairer()
    {
        $youngerFirstPersonsPairFactory = new YoungerFirstPersonsPairFactory();
        $this->personsPairer            =
            new SequentialPersonsPairer($youngerFirstPersonsPairFactory);
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
        $this->allPersons = [PersonStub::from1950()];
    }

    private function givenASetWithTwoDifferentPeople()
    {
        $this->allPersons = [PersonStub::from1950(), PersonStub::from1952()];
    }

    private function givenAnUnorderedSetWithFourPeople()
    {
        $this->allPersons = [
            PersonStub::from1950(),
            PersonStub::from1982(),
            PersonStub::from1979(),
            PersonStub::from1952()
        ];
    }

    private function givenAClosestBirthDateCriteria()
    {
        $this->personsPairsCriteria = new ClosestBirthDateCriteria();
    }

    private function givenAFurthestBirthDateCriteria()
    {
        $this->personsPairsCriteria = new FurthestBirthDateCriteria();
    }

    /*
     * Thens
     */

    private function thenItShouldThrowANotEnoughPeopleException()
    {
        $this->expectException(NotEnoughPeopleException::class);
    }

    private function thenItReturnsTheTwoGivenPeople()
    {
        $this->assertEquals(
            $this->allPersons[0],
            $this->personsPairFound->person1()
        );
        $this->assertEquals(
            $this->allPersons[1],
            $this->personsPairFound->person2()
        );
    }

    private function thenItReturnsTheTwoFurthestPeople()
    {
        $this->assertEquals(
            PersonStub::from1950(),
            $this->personsPairFound->person1()
        );
        $this->assertEquals(
            PersonStub::from1982(),
            $this->personsPairFound->person2()
        );
    }

    private function thenItReturnsTheTwoClosestPeople()
    {
        $this->assertEquals(
            PersonStub::from1950(),
            $this->personsPairFound->person1()
        );
        $this->assertEquals(
            PersonStub::from1952(),
            $this->personsPairFound->person2()
        );
    }

    /*
     * Whens
     */

    private function whenFinderIsCalled()
    {
        $finder = new BestPersonPairFinder($this->personsPairer);

        $this->personsPairFound =
            $finder($this->allPersons, $this->personsPairsCriteria);
    }
}
