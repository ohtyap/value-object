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

namespace Ohtyap\Test\ValueObject\Convert;

use Ohtyap\ValueObject\Convert\Convert;
use Ohtyap\ValueObject\Exception\TransformException;
use Ohtyap\ValueObject\ValueObjectInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ohtyap\ValueObject\Convert\Convert
 */
class ConvertTest extends TestCase
{
    /**
     * @dataProvider provideValidConvertStrings
     */
    public function testValidStringConvert(mixed $convertString, string $checkString): void
    {
        self::assertSame($checkString, Convert::convertToString($convertString, ValueObjectInterface::class));
    }

    /**
     * @return array<array<mixed>>
     */
    public function provideValidConvertStrings(): array
    {
        return [
            ['a string', 'a string'],
            [
                new class implements \Stringable
                {
                    public function __toString(): string
                    {
                        return 'another string';
                    }
                },
                'another string'
            ]
        ];
    }

    /**
     * @dataProvider provideInvalidConvertStrings
     */
    public function testInvalidStringConvert(mixed $convertString): void
    {
        $this->expectException(TransformException::class);
        Convert::convertToString($convertString, ValueObjectInterface::class);
    }

    /**
     * @return array<array<mixed>>
     */
    public function provideInvalidConvertStrings(): array
    {
        return [
            [new \DateTime()],
            [['an', 'array']],
            [false],
            [true],
            [null],
            [12],
            [12.5],
            [\fopen('php://memory', 'r')],
        ];
    }
}
