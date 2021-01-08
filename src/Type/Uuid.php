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

/**
 * @psalm-immutable
 */
final class Uuid implements ValueObjectInterface, \Stringable, TransformableInterface
{
    private string $uuid;

    /**
     * Uses code from {@link https://github.com/ramsey/uuid} that is MIT licensed.
     */
    public function __construct(string $uuid)
    {
        $uuid = \str_replace(['urn:', 'uuid:', 'URN:', 'UUID:', '{', '}'], '', $uuid);
        if ($uuid !== '00000000-0000-0000-0000-000000000000'
            && \preg_match('/\A[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}\z/Dms', $uuid) !== 1
        ) {
            throw new InvalidArgumentException(\sprintf("The given string '%s' is not a valid uuid.", $uuid));
        }
        $this->uuid = $uuid;
    }

    public static function transform(mixed $value): self
    {
        return new self(
            Convert::convertToString($value, self::class)
        );
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    public function value(): string
    {
        return $this->uuid;
    }

    public function equals(mixed $other): bool
    {
        return ValueObjectCompare::stringCompare($this, $other);
    }
}
