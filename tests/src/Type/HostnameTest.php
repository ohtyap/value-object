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

use Ohtyap\ValueObject\Type\Hostname;

/**
 * @covers \Ohtyap\ValueObject\Type\Hostname
 * @uses \Ohtyap\ValueObject\Compare\ValueObjectCompare
 * @uses \Ohtyap\ValueObject\Convert\Convert
 */
class HostnameTest extends AbstractScalarTypeTest
{
    protected string $type = Hostname::class;
    protected string $extraGetterMethod = 'hostname';

    /**
     * @return array<array<string>>
     */
    public function provideValidValues(): array
    {
        return [
            ['php.net', 'php.net'],
            ['localhost', 'localhost'],
        ];
    }

    /**
     * @return array<array<string>>
     */
    public function provideInvalidValues(): array
    {
        return [
            [''],
            ['php-.net'],
            ['-php.net'],
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
