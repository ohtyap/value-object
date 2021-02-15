<?php
declare(strict_types=1);

namespace Ohtyap\Test\ValueObject;

use Ohtyap\Misc\ValueObject\StringContainer;
use Ohtyap\Misc\ValueObject\ValueObjectWithoutTransformer;
use Ohtyap\ValueObject\Compare;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Ohtyap\ValueObject\Compare
 */
class CompareTest extends TestCase
{
    /**
     * @dataProvider provideStringData
     */
    public function testAsString(bool $result, string $value1, mixed $value2): void
    {
        self::assertSame($result, Compare::asString($value1, $value2));
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideStringData(): array
    {
        return [
            [true, 'a_string', 'a_string'],
            [true, 'a_string', new ValueObjectWithoutTransformer('a_string')],
            [true, 'a_string', new StringContainer('a_string')],
            [false, 'a_string', 'another_string'],
            [false, 'a_string', new ValueObjectWithoutTransformer('another_string')],
            [false, 'a_string', new StringContainer('another_string')],
            [false, 'a_string', 12],
            [false, 'a_string', new stdClass()],
        ];
    }

    /**
     * @dataProvider provideIntData
     */
    public function testAsInt(bool $result, int $value1, mixed $value2): void
    {
        self::assertSame($result, Compare::asInt($value1, $value2));
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideIntData(): array
    {
        return [
            [true, 5000, 5000],
            [true, 5000, new ValueObjectWithoutTransformer(5000)],
            [true, 5000, 5000.9],
            [true, 5000, '5000'],
            [false, 5000, new ValueObjectWithoutTransformer(5001)],
            [false, 5000, new ValueObjectWithoutTransformer('5001')],
            [false, 5000, 5001],
            [false, 5000, '5001string'],
        ];
    }

    /**
     * @dataProvider provideFloatData
     */
    public function testAsFloat(bool $result, float $value1, mixed $value2): void
    {
        self::assertSame($result, Compare::asFloat($value1, $value2));
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideFloatData(): array
    {
        return [
            [true, (float) 5000, 5000],
            [true, 5000.9, 5000.9],
            [true, 5000.9, new ValueObjectWithoutTransformer(5000.9)],
            [true, 5000.9, '5000.9'],
            [false, 5000.9, new ValueObjectWithoutTransformer(5001.98)],
            [false, 5000.9, new ValueObjectWithoutTransformer('5001.98')],
            [false, 5000.9, 5001],
            [false, 5000.9, '5001string'],
        ];
    }
}
