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

final class Ip implements ValueObjectInterface, Stringable, TransformableInterface
{
    private string $ip;
    private int $version;

    public function __construct(string $ip)
    {
        if (\filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
            $this->version = 4;
        } elseif (\filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
            $this->version = 6;
        } else {
            throw new InvalidArgumentException(\sprintf("The given string '%s' is not a valid ip.", $ip));
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

    public function version(): int
    {
        return $this->version;
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
