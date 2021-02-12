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

use Ohtyap\Misc\ValueObject\ValueObjectWithoutTransformer;
use Ohtyap\ValueObject\Exception\InvalidArgumentException;
use Ohtyap\ValueObject\Exception\TransformException;
use Ohtyap\ValueObject\TransformableInterface;
use Ohtyap\ValueObject\ValueObjectInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractScalarTypeTest extends TestCase
{
    /**
     * @var class-string<ValueObjectInterface>
     */
    protected string $type;

    protected string $extraGetterMethod;

    /**
     * @dataProvider provideValidValues
     */
    public function testValidValues(int|float|string $expected, int|float|string $value): void
    {
        $valueObject = new $this->type($value);
        self::assertSame($expected, $valueObject->value());

        /** @phpstan-ignore-next-line */
        if (!empty($this->extraGetterMethod)) {
            /** @phpstan-ignore-next-line */
            self::assertSame($expected, $valueObject->{$this->extraGetterMethod}());
        }

        if ($valueObject instanceof \Stringable && \is_string($expected)) {
            self::assertSame($expected, (string) $valueObject);
        }

    }

    /**
     * @dataProvider provideInvalidValues
     */
    public function testInvalidValues(int|float|string $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        new $this->type($value);
    }

    /**
     * @dataProvider provideEqualsData
     */
    public function testEquals(bool $check, ValueObjectInterface $value1, mixed $value2): void
    {
        self::assertSame($check, $value1->equals($value2));
    }

    /**
     * @return array<array<mixed>>
     */
    public function provideEqualsData(): array
    {
        $data = [];

        $validValues = $this->provideValidValues();
        if (\count($validValues) < 2) {
            throw new \Exception('Please provide at least 2 values for valid data');
        }
        $data[] = [true, new $this->type($validValues[0][0]), $validValues[0][0]];
        $data[] = [true, new $this->type($validValues[0][0]), new $this->type($validValues[0][0])];
        $data[] = [false, new $this->type($validValues[0][0]), $validValues[1][0]];
        $data[] = [false, new $this->type($validValues[0][0]), new $this->type($validValues[1][0])];
        $obj = new \stdClass();
        $obj->data = '97f938a2-b594-407f-84ad-ac9bfa4ff68b';
        $data[] = [false, new $this->type($validValues[0][0]), new ValueObjectWithoutTransformer($obj)];

        return $data;
    }

    /**
     * @dataProvider provideValidCreateOptions
     */
    public function testValidCreate(mixed $expectedValue, mixed $actual): void
    {
        /** @var class-string<TransformableInterface> $type */
        $type = $this->type;

        $valueObject = $type::transform($actual);
        self::assertSame($expectedValue, $valueObject->value());
    }

    /**
     * @return array<array<mixed>>
     */
    public function provideValidCreateOptions(): array
    {
        $data = [];

        $validValues = $this->provideValidValues();
        if (\count($validValues) < 2) {
            throw new \Exception('Please provide at least 2 values for valid data');
        }

        $data[] = [$validValues[0][0], $validValues[0][1]];
        $type = new $this->type($validValues[0][1]);
        $data[] = [$validValues[0][0], $type];
        if ($type instanceof \Stringable && \is_string($validValues[0][0])) {
            $data[] = [$validValues[0][0],
                new class ($validValues[0][1]) implements \Stringable
                {
                    public function __construct(private string $value)
                    {

                    }

                    public function __toString(): string
                    {
                        return $this->value;
                    }
                }

            ];
        }

        return $data;
    }

    /**
     *
     * @dataProvider provideUnsupportedTypes
     */
    public function testInvalidCreate(mixed $value): void
    {
        /** @var class-string<TransformableInterface> $type */
        $type = $this->type;
        $this->expectException(TransformException::class);
        $type::transform($value);
    }

    /**
     * @return array<array<mixed>>
     */
    abstract public function provideValidValues(): array;

    /**
     * @return array<array<mixed>>
     */
    abstract public function provideInvalidValues(): array;

    /**
     * @return array<array<mixed>>
     */
    abstract public function provideUnsupportedTypes(): array;
}
