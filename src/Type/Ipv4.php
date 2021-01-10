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

final class Ipv4 implements ValueObjectInterface, Stringable, TransformableInterface
{
    private string $ip;

    public function __construct(string $ip)
    {
        if (\filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
            throw new InvalidArgumentException(\sprintf("The given string '%s' is not a valid ipv4 address.", $ip));
        }

        $this->ip = $ip;
    }

    public static function transform(mixed $value): self
    {
        return new self(
            Convert::convertToString($value, self::class)
        );
    }

    public function ip(): string
    {
        return $this->ip;
    }

    public function __toString(): string
    {
        return $this->ip;
    }

    public function value(): string
    {
        return $this->ip;
    }

    public function equals(mixed $other): bool
    {
        return ValueObjectCompare::stringCompare($this, $other);
    }
}
