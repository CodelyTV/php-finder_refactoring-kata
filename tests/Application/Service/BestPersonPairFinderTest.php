<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKataTest\Application\Service;

use CodelyTV\FinderKata\Application\Service\BestPeoplePairFinder;
use CodelyTV\FinderKata\Application\Service\NotEnoughPeopleException;
use CodelyTV\FinderKata\Domain\Model\People;
use CodelyTV\FinderKata\Domain\Model\PeoplePair;
use CodelyTV\FinderKata\Domain\Model\PeoplePairCriterion\ClosestBirthDateCriterion;
use CodelyTV\FinderKata\Domain\Model\PeoplePairCriterion\FurthestBirthDateCriterion;
use CodelyTV\FinderKata\Domain\Model\PeoplePairCriterion\PeoplePairCriterion;
use CodelyTV\FinderKata\Domain\Service\PeoplePair\YoungerFirstPeoplePairFactory;
use CodelyTV\FinderKata\Domain\Service\PeoplePairer\PeoplePairer;
use CodelyTV\FinderKata\Domain\Service\PeoplePairer\SequentialPeoplePairer;
use CodelyTV\FinderKataTest\Domain\Stub\PeopleStub;
use CodelyTV\FinderKataTest\Domain\Stub\PersonStub;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

final class BestPersonPairFinderTest extends TestCase
{
    /** @var PeoplePairer|PHPUnit_Framework_MockObject_MockObject */
    private $personsPairer;
    /** @var People */
    private $allPersons;
    /** @var PeoplePairCriterion */
    private $personsPairsCriteria;
    /** @var PeoplePair */
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
    public function should_throw_not_enough_persons_exception_when_given_empty_set()
    {
        $this->havingAPersonsPairer();

        $this->givenAnEmptySetOfPersons();
        $this->givenAClosestBirthDateCriteria();

        $this->thenItShouldThrowANotEnoughPeopleException();

        $this->whenFinderIsCalled();
    }

    /** @test */
    public function should_throw_not_enough_persons_exception_when_given_one_person()
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
        $this->personsPairer = $this->createMock(PeoplePairer::class);
    }

    private function havingASequentialPersonsPairer()
    {
        $youngerFirstPersonsPairFactory = new YoungerFirstPeoplePairFactory();
        $this->personsPairer            =
            new SequentialPeoplePairer($youngerFirstPersonsPairFactory);
    }

    /*
     * Given
     */

    private function givenAnEmptySetOfPersons()
    {
        $this->allPersons = PeopleStub::withNoOne();
    }

    private function givenASetWithOnePerson()
    {
        $this->allPersons = PeopleStub::create(PersonStub::from1950());
    }

    private function givenASetWithTwoDifferentPeople()
    {
        $this->allPersons = PeopleStub::create(PersonStub::from1950(), PersonStub::from1952());
    }

    private function givenAnUnorderedSetWithFourPeople()
    {
        $this->allPersons = PeopleStub::create(
            PersonStub::from1950(),
            PersonStub::from1982(),
            PersonStub::from1979(),
            PersonStub::from1952()
        );
    }

    private function givenAClosestBirthDateCriteria()
    {
        $this->personsPairsCriteria = new ClosestBirthDateCriterion();
    }

    private function givenAFurthestBirthDateCriteria()
    {
        $this->personsPairsCriteria = new FurthestBirthDateCriterion();
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
        $allPersons = $this->allPersons->all();

        $this->assertEquals(
            $allPersons[0],
            $this->personsPairFound->person1()
        );
        $this->assertEquals(
            $allPersons[1],
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
        $finder = new BestPeoplePairFinder($this->personsPairer);

        $this->personsPairFound = $finder($this->allPersons, $this->personsPairsCriteria);
    }
}
