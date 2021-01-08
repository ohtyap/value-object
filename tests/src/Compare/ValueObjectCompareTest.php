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

namespace Ohtyap\Test\ValueObject\Compare;

use Ohtyap\ValueObject\Compare\ValueObjectCompare;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ohtyap\ValueObject\Compare\ValueObjectCompare
 */
class ValueObjectCompareTest extends TestCase
{
    /**
     * @dataProvider provideCompareData
     */
    public function testCompare(bool $compare, \Stringable $value1, mixed $value2): void
    {
        self::assertSame($compare, ValueObjectCompare::stringCompare($value1, $value2));
    }

    /**
     * @return array<array<mixed>>
     */
    public function provideCompareData(): array
    {
        return [
            [
                true,
                new class implements \Stringable {
                    function __toString()
                    {
                        return 'test';
                    }
                },
                'test',
            ],
            [
                true,
                new class implements \Stringable {
                    function __toString()
                    {
                        return 'test';
                    }
                },
                new class implements \Stringable {
                    function __toString()
                    {
                        return 'test';
                    }
                },
            ],
            [
                false,
                new class implements \Stringable {
                    function __toString()
                    {
                        return 'test';
                    }
                },
                'notsame',
            ],
            [
                false,
                new class implements \Stringable {
                    function __toString()
                    {
                        return 'test';
                    }
                },
                new class implements \Stringable {
                    function __toString()
                    {
                        return 'notsame';
                    }
                },
            ],
            [
                false,
                new class implements \Stringable {
                    function __toString()
                    {
                        return 'test';
                    }
                },
                new \DateTime(),
            ],
            [
                false,
                new class implements \Stringable {
                    function __toString()
                    {
                        return 'test';
                    }
                },
                12,
            ],
        ];
    }


}
