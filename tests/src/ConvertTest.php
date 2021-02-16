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

namespace Ohtyap\Test\ValueObject;

use Ohtyap\Misc\ValueObject\StringContainer;
use Ohtyap\Misc\ValueObject\ValueObjectWithoutTransformer;
use Ohtyap\Misc\ValueObject\ValueObjectWithTransformer;
use Ohtyap\ValueObject\Convert;
use Ohtyap\ValueObject\Exception\TransformException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Ohtyap\ValueObject\Convert
 */
class ConvertTest extends TestCase
{
    /**
     * @dataProvider provideValidStrings
     */
    public function testValidToString(mixed $actual, string $expected): void
    {
        self::assertSame($expected, Convert::toString($actual, ValueObjectWithTransformer::class));
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideValidStrings(): array
    {
        return [
            ['a_string', 'a_string'],
            [new StringContainer('a_string'), 'a_string'],
            [new ValueObjectWithoutTransformer('a_string'), 'a_string'],
            [new ValueObjectWithoutTransformer(new StringContainer('a_string')), 'a_string'],
        ];
    }

    /**
     * @dataProvider provideInvalidStrings
     */
    public function testInvalidToString(mixed $value): void
    {
        $this->expectException(TransformException::class);
        Convert::toString($value, ValueObjectWithTransformer::class);
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideInvalidStrings(): array
    {
        return [
            [['a_array']],
            [new stdClass()],
        ];
    }

    /**
     * @dataProvider provideValidIntegers
     */
    public function testValidToInt(mixed $actual, int $expected): void
    {
        self::assertSame($expected, Convert::toInt($actual, ValueObjectWithTransformer::class));
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideValidIntegers(): array
    {
        return [
            [5000, 5000],
            ['5000', 5000],
            [5000.9, 5000],
            [new ValueObjectWithoutTransformer(5000), 5000],
            [new ValueObjectWithoutTransformer('5000'), 5000],
            [new ValueObjectWithoutTransformer(5000.9), 5000],
        ];
    }

    /**
     * @dataProvider provideInvalidIntegers
     */
    public function testInvalidIntegers(mixed $value): void
    {
        $this->expectException(TransformException::class);
        Convert::toInt($value, ValueObjectWithTransformer::class);
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideInvalidIntegers(): array
    {
        return [
            [['a_array']],
            [new stdClass()],
            ['5000a_string'],
        ];
    }

    /**
     * @dataProvider provideValidFloats
     */
    public function testValidToFloat(mixed $actual, float $expected): void
    {
        self::assertSame($expected, Convert::toFloat($actual, ValueObjectWithTransformer::class));
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideValidFloats(): array
    {
        return [
            [5000.9, 5000.9],
            ['5000.9', 5000.9],
            [new ValueObjectWithoutTransformer(5000.9), 5000.9],
            [new ValueObjectWithoutTransformer('5000.9'), 5000.9],
        ];
    }

    /**
     * @dataProvider provideInvalidFloats
     */
    public function testInvalidFloats(mixed $value): void
    {
        $this->expectException(TransformException::class);
        Convert::toFloat($value, ValueObjectWithTransformer::class);
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideInvalidFloats(): array
    {
        return [
            [['a_array']],
            [new stdClass()],
            ['5000a_string'],
        ];
    }
}
