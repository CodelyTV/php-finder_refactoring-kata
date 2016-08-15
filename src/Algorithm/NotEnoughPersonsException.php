<?php

namespace CodelyTV\FinderKata\Algorithm;

final class NotEnoughPersonsException extends \InvalidArgumentException
{
    protected $message = "You have not specified enough persons in order to find a pair.";
}
