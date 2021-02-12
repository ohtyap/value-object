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

use Ohtyap\ValueObject\Type\HttpMethod;

/**
 * @covers \Ohtyap\ValueObject\Type\HttpMethod
 * @uses \Ohtyap\ValueObject\Compare\ValueObjectCompare
 * @uses \Ohtyap\ValueObject\Convert\Convert
 */
class HttpMethodTest extends AbstractScalarTypeTest
{
    protected string $type = HttpMethod::class;
    protected string $extraGetterMethod = 'httpMethod';

    /**
     * @return array<array<string>>
     */
    public function provideValidValues(): array
    {
        return [
            ['GET', 'get'],
            ['HEAD', 'head'],
            ['POST', 'post'],
            ['PUT', 'put'],
            ['DELETE', 'delete'],
            ['CONNECT', 'connect'],
            ['OPTIONS', 'options'],
            ['TRACE', 'trace'],
            ['PATCH', 'patch'],
            ['GET', 'GET'],
            ['HEAD', 'HEAD'],
            ['POST', 'POST'],
            ['PUT', 'PUT'],
            ['DELETE', 'DELETE'],
            ['CONNECT', 'CONNECT'],
            ['OPTIONS', 'OPTIONS'],
            ['TRACE', 'TRACE'],
            ['PATCH', 'PATCH'],
        ];
    }

    /**
     * @return array<array<string>>
     */
    public function provideInvalidValues(): array
    {
        return [
            [''],
            ['string'],
        ];
    }

    /**
     * @return array<array<mixed>>
     */
    public function provideUnsupportedTypes(): array
    {
        return [
            [['an', 'array']],
            [12],
            [13.567546],
            [false],
            [true],
            [null]
        ];
    }
}
