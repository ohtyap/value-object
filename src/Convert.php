<?php
declare(strict_types=1);

namespace Ohtyap\ValueObject;

use Ohtyap\ValueObject\Exception\TransformException;
use Stringable;

/**
 * @psalm-pure
 */
final class Convert
{
    /**
     * Constructor is set to private as instantiation of this class is not supported.
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * @param string|ValueObjectInterface|Stringable $value
     * @param class-string<ValueObjectInterface> $valueObject
     *
     * @throws TransformException
     */
    public static function toString(mixed $value, string $valueObject): string
    {
        try {
            if ($value instanceof ValueObjectInterface) {
                return (string) $value->value();
            }

            return (string) $value;
        } catch (\Throwable) {
            throw new TransformException(\sprintf("Type '%s' can't be used to create value object '%s'.", \gettype($value), $valueObject));
        }
    }

    public static function toInt(mixed $value, string $valueObject): int
    {
        if ($value instanceof ValueObjectInterface) {
            /**
             * @psalm-suppress MixedAssignment It's covered by is_numeric few lines below.
             */
            $value = $value->value();
        }

        if (\is_numeric($value)) {
            return (int) $value;
        }

        throw new TransformException(\sprintf("Type '%s' can't be used to create value object '%s'.", \gettype($value), $valueObject));
    }

    public static function toFloat(mixed $value, string $valueObject): float
    {
        if ($value instanceof ValueObjectInterface) {
            /**
             * @psalm-suppress MixedAssignment It's covered by is_numeric few lines below.
             */
            $value = $value->value();
        }

        if (\is_numeric($value)) {
            return (float) $value;
        }

        throw new TransformException(\sprintf("Type '%s' can't be used to create value object '%s'.", \gettype($value), $valueObject));
    }
}
