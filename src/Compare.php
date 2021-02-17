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

use Stringable;

final class Compare
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
     * @psalm-mutation-free
     * @psalm-suppress MixedAssignment Mixed values are allowed by design - in case of an invalid value `false` is returned.
     */
    public static function asFloat(float $value1, mixed $value2): bool
    {
        if ($value2 instanceof ValueObjectInterface) {
            $value2 = $value2->value();
        }

        if (!\is_numeric($value2)) {
            return false;
        }

        return $value1 === (float) $value2;
    }

    /**
     * @psalm-mutation-free
     * @psalm-suppress MixedAssignment Mixed values are allowed by design - in case of an invalid value `false` is returned.
     */
    public static function asInt(int $value1, mixed $value2): bool
    {
        if ($value2 instanceof ValueObjectInterface) {
            $value2 = $value2->value();
        }

        if (!\is_numeric($value2)) {
            return false;
        }

        return $value1 === (int) $value2;
    }

    /**
     * @psalm-mutation-free
     * @psalm-suppress MixedAssignment Mixed values are allowed by design - in case of an invalid value `false` is returned.
     */
    public static function asString(string $value1, mixed $value2): bool
    {
        if ($value2 instanceof ValueObjectInterface) {
            $value2 = $value2->value();
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
