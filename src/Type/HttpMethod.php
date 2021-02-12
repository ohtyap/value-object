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
final class HttpMethod implements ValueObjectInterface, Stringable, TransformableInterface
{
    private const AVAILABLE_METHODS = ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'];

    private string $httpMethod;

    public function __construct(string $httpMethod)
    {
        $httpMethod = \strtoupper($httpMethod);
        if (!\in_array($httpMethod, self::AVAILABLE_METHODS, true)) {
            throw new InvalidArgumentException(\sprintf(
                "The given string '%s' is not a valid http method, only %s is allowed.",
                $httpMethod,
                \implode(', ', self::AVAILABLE_METHODS)
            ));
        }

        $this->httpMethod = $httpMethod;
    }

    public static function transform(mixed $value): self
    {
        return new self(
            Convert::convertToString($value, self::class)
        );
    }

    public function httpMethod(): string
    {
        return $this->httpMethod;
    }

    public function __toString(): string
    {
        return $this->httpMethod;
    }

    public function value(): string
    {
        return $this->httpMethod;
    }

    public function equals(mixed $other): bool
    {
        if (\is_string($other)) {
            $other = \strtoupper($other);
        }

        return ValueObjectCompare::stringCompare($this, $other);
    }
}
