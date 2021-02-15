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
class HttpStatusCode implements ValueObjectInterface, TransformableInterface
{
    private int $httpStatusCode;

    public function __construct(int $httpStatusCode)
    {
        if (!\in_array($httpStatusCode, [
            100,
            101,
            102,
            200,
            201,
            202,
            203,
            204,
            205,
            206,
            207,
            208,
            226,
            300,
            301,
            302,
            303,
            304,
            305,
            307,
            308,
            400,
            401,
            402,
            403,
            404,
            405,
            406,
            407,
            408,
            409,
            410,
            411,
            412,
            413,
            414,
            415,
            416,
            417,
            418,
            421,
            422,
            423,
            424,
            426,
            428,
            429,
            431,
            444,
            451,
            499,
            500,
            501,
            502,
            503,
            504,
            505,
            506,
            507,
            508,
            510,
            511,
            599,
        ], true)) {
            throw new InvalidArgumentException(\sprintf("The given integer '%d' is not a valid http status code.", $httpStatusCode));
        }
        $this->httpStatusCode = $httpStatusCode;
    }

    public static function transform(mixed $value): self
    {
        return new self(
            Convert::convertToInt($value, self::class)
        );
    }

    public function httpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function value(): int
    {
        return $this->httpStatusCode;
    }

    public function equals(mixed $other): bool
    {
        return ValueObjectCompare::intCompare($this, $other);
    }
}
