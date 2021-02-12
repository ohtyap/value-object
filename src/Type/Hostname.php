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
final class Hostname implements ValueObjectInterface, Stringable, TransformableInterface
{
    private string $hostname;

    public function __construct(string $hostname)
    {
        if (\filter_var($hostname, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) === false) {
            throw new InvalidArgumentException(\sprintf("The given string '%s' is not a valid hostname.", $hostname));
        }
        $this->hostname = $hostname;
    }

    public static function transform(mixed $value): self
    {
        return new self(
            Convert::convertToString($value, self::class)
        );
    }

    public function hostname(): string
    {
        return $this->hostname;
    }

    public function __toString(): string
    {
        return $this->hostname;
    }

    public function value(): string
    {
        return $this->hostname;
    }

    public function equals(mixed $other): bool
    {
        return ValueObjectCompare::stringCompare($this, $other);
    }
}
