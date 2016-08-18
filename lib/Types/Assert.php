<?php

namespace CodelyTV\Types;

use InvalidArgumentException;

final class Assert
{
    public static function arrayOf(string $class, array $items)
    {
        foreach ($items as $item) {
            self::instanceOf($class, $item);
        }
    }

    public static function instanceOf($class, $item)
    {
        if (!$item instanceof $class) {
            throw new InvalidArgumentException(
                sprintf('The object <%s> is not an instance of <%s>', get_class($item), $class)
            );
        }
    }
}
