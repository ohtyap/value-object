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

namespace Ohtyap\ValueObject\Compare;

use Ohtyap\ValueObject\ValueObjectInterface;

final class ValueObjectCompare
{
    /**
     * @psalm-pure
     */
    public static function stringCompare(ValueObjectInterface $value1, mixed $value2): bool
    {
        if ($value2 instanceof \Stringable) {
            $value2 = (string) $value2;
        } elseif ($value2 instanceof ValueObjectInterface) {
            $value2 = $value2->value();
        }

        if (!\is_string($value2)) {
            return false;
        }

        return $value1->value() === $value2;
    }

    /**
     * @psalm-pure
     */
    public static function intCompare(ValueObjectInterface $value1, mixed $value2): bool
    {
        if ($value2 instanceof ValueObjectInterface) {
            $value2 = $value2->value();
        }

        if (\is_numeric($value2)) {
            $value2 = (int) $value2;
        }

        return $value1->value() === $value2;
    }
}
