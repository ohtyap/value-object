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

namespace Ohtyap\ValueObject\Type;

use Ohtyap\ValueObject\Compare\ValueObjectCompare;
use Ohtyap\ValueObject\Convert\Convert;
use Ohtyap\ValueObject\Exception\InvalidArgumentException;
use Ohtyap\ValueObject\TransformableInterface;
use Ohtyap\ValueObject\ValueObjectInterface;
use Stringable;

/**
 * @psalm-immutable
 */
final class Email implements ValueObjectInterface, TransformableInterface, Stringable
{
    private string $email;

    public function __construct(string $email)
    {
        if (\filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException(\sprintf("The given string '%s' is not a valid email.", $email));
        }
        $this->email = $email;
    }

    public static function transform(mixed $value): self
    {
        return new self(
            Convert::convertToString($value, self::class)
        );
    }

    public function email(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function value(): string
    {
        return $this->email;
    }

    public function equals(mixed $other): bool
    {
        return ValueObjectCompare::stringCompare($this, $other);
    }
}
