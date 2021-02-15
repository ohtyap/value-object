<?php
declare(strict_types=1);

namespace Ohtyap\ValueObject;

use Stringable;

/**
 * @psalm-pure
 */
final class Compare
{
    /**
     * Constructor is set to private as instantiation of this class is not supported.
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    public static function asFloat(float $value1, mixed $value2): bool
    {
        if ($value2 instanceof ValueObjectInterface) {
            /**
             * @psalm-suppress MixedAssignment It's covered by is_numeric few lines below.
             */
            $value2 =  $value2->value();
        }

        if (!\is_numeric($value2)) {
            return false;
        }

        return $value1 === (float) $value2;
    }

    public static function asInt(int $value1, mixed $value2): bool
    {
        if ($value2 instanceof ValueObjectInterface) {
            /**
             * @psalm-suppress MixedAssignment It's covered by is_numeric few lines below.
             */
            $value2 =  $value2->value();
        }

        if (!\is_numeric($value2)) {
            return false;
        }

        return $value1 === (int) $value2;
    }

    public static function asString(string $value1, mixed $value2): bool
    {
        if ($value2 instanceof ValueObjectInterface) {
            /**
             * @psalm-suppress MixedAssignment It's covered by is_string few lines below.
             */
            $value2 =  $value2->value();
        }

        if ($value2 instanceof Stringable) {
            $value2 = (string) $value2;
        }

        if (!\is_string($value2)) {
            return false;
        }

        return $value1 === $value2;
    }
}
