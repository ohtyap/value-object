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

interface ValueObjectInterface
{
    /**
     * @psalm-pure
     */
    public function value(): mixed;

    /**
     * Compare the value object with another value (another value object or a native type) and evaluated it they
     * can be considered as equal.
     *
     * @psalm-pure
     */
    public function equals(mixed $other): bool;
}
