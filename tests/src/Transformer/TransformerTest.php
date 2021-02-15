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

namespace Ohtyap\Test\ValueObject\Transformer;

use Ohtyap\Misc\ValueObject\Transformable;
use Ohtyap\Misc\ValueObject\ValueObjectWithoutTransformer;
use Ohtyap\Misc\ValueObject\ValueObjectWithTransformer;
use Ohtyap\ValueObject\Exception\TransformException;
use Ohtyap\ValueObject\TransformableInterface;
use Ohtyap\ValueObject\Transformer\Transformer;
use Ohtyap\ValueObject\ValueObjectInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ohtyap\ValueObject\Transformer\Transformer
 */
class TransformerTest extends TestCase
{

    public function testTransform(): void
    {
        $transformer = new Transformer();
        $transformer->add(ValueObjectWithTransformer::class);

        $valueObject = $transformer->transformValue(ValueObjectWithTransformer::class, 'test');
        self::assertSame('test', $valueObject->value());
        self::assertInstanceOf(ValueObjectWithTransformer::class, $valueObject);
    }

    public function testInvalidTransform(): void
    {
        $this->expectException(TransformException::class);
        $transformer = new Transformer();
        $transformer->transformValue(ValueObjectWithTransformer::class, '');
    }

    /**
     * @dataProvider provideValidAdd
     *
     * @param class-string<ValueObjectInterface> $type
     * @param class-string<TransformableInterface>|null $transformable
     */
    public function testValidAdd(string $type, ?string $transformable = null): void
    {
        $transformer = new Transformer();
        $transformer->add($type, $transformable);

        $valueObject = $transformer->transformValue($type, ['a value']);
        self::assertSame(['a value'], $valueObject->value());
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideValidAdd(): array
    {
        return [
            [ValueObjectWithTransformer::class, null],
            [ValueObjectWithoutTransformer::class, Transformable::class],
        ];
    }

    /**
     * @dataProvider provideInvalidAdd
     *
     * @param class-string<ValueObjectInterface> $type
     * @param class-string<TransformableInterface>|null $transformable
     */
    public function testInvalidAdd(string $type, ?string $transformable = null): void
    {
        $this->expectException(TransformException::class);

        (new Transformer())->add($type, $transformable);
    }

    /**
     * @return array<array<int, mixed>>
     */
    public function provideInvalidAdd(): array
    {
        return [
            ['invalid', null],
            [\DateTime::class, null],
            [\DateTime::class, Transformable::class],
            [ValueObjectWithoutTransformer::class, null],
            [ValueObjectWithoutTransformer::class, 'invalid'],
            [ValueObjectWithTransformer::class, \DateTime::class],
            [ValueObjectWithoutTransformer::class, \DateTime::class],
        ];
    }
}
