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

namespace Ohtyap\ValueObject\Convert;

use Ohtyap\ValueObject\Exception\TransformException;

final class Convert
{
    /**
     * @psalm-pure
     *
     * @param class-string $valueObject
     */
    public static function convertToString(mixed $value, string $valueObject): string
    {
        if (\is_string($value)) {
            return $value;
        }

        if ($value instanceof \Stringable) {
            return (string) $value;
        }

        throw new TransformException(\sprintf("Type '%s' can't be used to create value object '%s'.", \gettype($value), $valueObject));
    }
}
