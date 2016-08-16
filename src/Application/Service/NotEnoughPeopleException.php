<?php

namespace CodelyTV\FinderKata\Application\Service;

final class NotEnoughPeopleException extends \InvalidArgumentException
{
    protected $message = "You have not specified enough people in order to find the best pair.";
}