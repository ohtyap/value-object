<?php
/*
 * This file is part of the ohtyap/value-object library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Thomas Payer <me@tpa.codes>
 * @license http://opensource.org/licenses/MIT MIT
 */

declare(strict_types=1);

namespace Ohtyap\ValueObject;

use Ohtyap\ValueObject\Exception\TransformException;

/**
 * @psalm-pure
 */
final class Convert
{
    /**
     * Constructor is set to private as instantiation of this class is not supported.
     *
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
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

    /**
     * @param class-string<ValueObjectInterface> $valueObject
     *
     * @psalm-suppress MixedAssignment Mixed values are allowed by design - in case of an invalid value an exception
     * is thrown.
     *
     * @throws TransformException
     */
    public static function toInt(mixed $value, string $valueObject): int
    {
        if ($value instanceof ValueObjectInterface) {
            $value = $value->value();
        }

        if (\is_numeric($value)) {
            return (int) $value;
        }

        throw new TransformException(\sprintf("Type '%s' can't be used to create value object '%s'.", \gettype($value), $valueObject));
    }

    /**
     * @param class-string<ValueObjectInterface> $valueObject
     *
     * @psalm-suppress MixedAssignment Mixed values are allowed by design - in case of an invalid value an exception
     * is thrown.
     *
     * @throws TransformException
     */
    public static function toFloat(mixed $value, string $valueObject): float
    {
        if ($value instanceof ValueObjectInterface) {
            $value = $value->value();
        }

        if (\is_numeric($value)) {
            return (float) $value;
        }

        throw new TransformException(\sprintf("Type '%s' can't be used to create value object '%s'.", \gettype($value), $valueObject));
    }
}
