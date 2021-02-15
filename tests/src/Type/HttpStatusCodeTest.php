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

namespace Ohtyap\Test\ValueObject\Type;

use Ohtyap\ValueObject\Type\HttpStatusCode;

/**
 * @covers \Ohtyap\ValueObject\Type\HttpStatusCode
 * @uses \Ohtyap\ValueObject\Compare\ValueObjectCompare
 * @uses \Ohtyap\ValueObject\Convert\Convert
 */
class HttpStatusCodeTest extends AbstractScalarTypeTest
{
    protected string $type = HttpStatusCode::class;
    protected string $extraGetterMethod = 'httpStatusCode';

    /**
     * @var array<int>
     */
    protected array $validStatusCodes = [
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
    ];

    /**
     * @return array<array<int, int>>
     */
    public function provideValidValues(): array
    {
        $result = [];

        foreach ($this->validStatusCodes as $statusCode) {
            $result[] = [$statusCode, $statusCode];
        }

        return $result;
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideInvalidValues(): array
    {
        return [
            [0],
        ];
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideUnsupportedTypes(): array
    {
        return [
            [['an', 'array']],
            ['string'],
            [false],
            [true],
            [null]
        ];
    }
}
