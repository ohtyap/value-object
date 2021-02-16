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
use Ohtyap\ValueObject\Transformer\Schema;
use Ohtyap\ValueObject\Transformer\Transformer;
use Ohtyap\ValueObject\ValueObjectInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ohtyap\ValueObject\Transformer\Transformer
 * @uses \Ohtyap\ValueObject\Transformer\Schema
 */
class TransformerTest extends TestCase
{

    public function testTransformValue(): void
    {
        $transformer = new Transformer();
        $transformer->addType(ValueObjectWithTransformer::class);

        $valueObject = $transformer->transformValue(ValueObjectWithTransformer::class, 'test');
        self::assertSame('test', $valueObject->value());
        self::assertInstanceOf(ValueObjectWithTransformer::class, $valueObject);
    }



    public function testInvalidTransformValue(): void
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
        $transformer->addType($type, $transformable);

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

        (new Transformer())->addType($type, $transformable);
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

    public function testHasSchema(): void
    {
        $transformer = new Transformer();
        $transformer->addSchema(new Schema('test1'));
        $transformer->addSchema(new Schema('test2'));

        self::assertTrue($transformer->hasSchema('test1'));
        self::assertTrue($transformer->hasSchema('test2'));
        self::assertFalse($transformer->hasSchema('test3'));
    }

    public function testTransform(): void
    {
        $transformer = new Transformer();
        $transformer->addType(ValueObjectWithTransformer::class);
        $transformer->addType(ValueObjectWithoutTransformer::class, Transformable::class);

        $schema = new Schema('test');
        $schema->addProperty('prop1', ValueObjectWithTransformer::class);
        $schema->addProperty('prop2', ValueObjectWithTransformer::class);
        $schema->addProperty('prop3', ValueObjectWithTransformer::class);
        $schema->addProperty('prop4', ValueObjectWithoutTransformer::class);
        $transformer->addSchema($schema);

        $originalValues = [
            'prop1' => 'value1',
            'not_part1' => 'doesnotmatter',
            'prop2' => 'value2',
            'prop4' => 'value4',
        ];
        $result = $transformer->transformBySchema('test', $originalValues);
        self::assertCount(3, $result);
        self::assertArrayHasKey('prop1', $result);
        self::assertArrayHasKey('prop2', $result);
        self::assertArrayHasKey('prop4', $result);
        self::assertInstanceOf(ValueObjectWithTransformer::class, $result['prop1']);
        self::assertInstanceOf(ValueObjectWithTransformer::class, $result['prop2']);
        self::assertInstanceOf(ValueObjectWithoutTransformer::class, $result['prop4']);
        self::assertSame('value1', $result['prop1']->value());
        self::assertSame('value2', $result['prop2']->value());
        self::assertSame('value4', $result['prop4']->value());
    }

    public function testInvalidSchemaTransform(): void
    {
        $this->expectException(TransformException::class);
        $transformer = new Transformer();
        $transformer->transformBySchema('test1', []);
    }
}
