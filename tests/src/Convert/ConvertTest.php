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
     * @dataProvider provideValidConvert
     */
    public function testValidConvert(string $method, mixed $convertString, mixed $checkString): void
    {
        // @phpstan-ignore-next-line
        self::assertSame($checkString, Convert::{$method}($convertString, ValueObjectInterface::class));
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideValidConvert(): array
    {
        return [
            ['convertToString', 'a string', 'a string'],
            [
                'convertToString',
                new class implements \Stringable
                {
                    public function __toString(): string
                    {
                        return 'another string';
                    }
                },
                'another string'
            ],
            [
                'convertToString',
                new class implements ValueObjectInterface
                {
                    public function value(): string
                    {
                        return 'another string';
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                'another string'
            ],

            ['convertToInt', 5000, 5000],
            ['convertToInt', 5000.9, 5000],
            ['convertToInt', '5000', 5000],
            [
                'convertToInt',
                new class implements ValueObjectInterface
                {

                    public function value(): int
                    {
                        return 5000;
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                5000
            ],
            [
                'convertToInt',
                new class implements ValueObjectInterface
                {

                    public function value(): string
                    {
                        return '5000';
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                5000
            ],
        ];
    }

    /**
     * @dataProvider provideInvalidConvert
     */
    public function testInvalidConvert(string $method, mixed $convertString): void
    {
        $this->expectException(TransformException::class);
        // @phpstan-ignore-next-line
        Convert::{$method}($convertString, ValueObjectInterface::class);
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideInvalidConvert(): array
    {
        return [
            ['convertToString', new \DateTime()],
            ['convertToString', ['an', 'array']],
            ['convertToString', false],
            ['convertToString', true],
            ['convertToString', null],
            ['convertToString', 12],
            ['convertToString', 12.5],
            ['convertToString', \fopen('php://memory', 'rb')],

            ['convertToInt', new \DateTime()],
            ['convertToInt', ['an', 'array']],
            ['convertToInt', false],
            ['convertToInt', true],
            ['convertToInt', null],
            ['convertToInt', '1abc'],
            ['convertToInt', \fopen('php://memory', 'rb')],
        ];
    }
}
