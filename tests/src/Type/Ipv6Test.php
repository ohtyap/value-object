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

use Ohtyap\ValueObject\Type\Ipv6;

/**
 * @covers \Ohtyap\ValueObject\Type\Ipv6
 * @uses \Ohtyap\ValueObject\Compare\ValueObjectCompare
 * @uses \Ohtyap\ValueObject\Convert\Convert
 */
class Ipv6Test extends AbstractScalarTypeTest
{
    protected string $type = Ipv6::class;
    protected string $extraGetterMethod = 'ip';

    /**
     * @return array<array<string>>
     */
    public function provideValidValues(): array
    {
        return [
            ['2001:4860:4860::8888', '2001:4860:4860::8888'],
            ['2001:4860:4860::8844', '2001:4860:4860::8844'],
        ];
    }

    /**
     * @return array<array<string>>
     */
    public function provideInvalidValues(): array
    {
        return [
            ['fe80:2030:31:24'],
            ['4.4.4.4'],
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
