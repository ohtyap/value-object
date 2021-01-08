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
use Ohtyap\ValueObject\Type\Email;
use Ohtyap\ValueObject\Type\Hostname;
use Ohtyap\ValueObject\Type\Ip;
use Ohtyap\ValueObject\Type\Ipv4;
use Ohtyap\ValueObject\Type\Ipv6;
use Ohtyap\ValueObject\Type\Url;
use Ohtyap\ValueObject\Type\Uuid;
use Ohtyap\ValueObject\ValueObjectInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ohtyap\ValueObject\Transformer\Transformer
 * @uses \Ohtyap\ValueObject\Convert\Convert
 * @uses \Ohtyap\ValueObject\Type\Email
 * @uses \Ohtyap\ValueObject\Type\Hostname
 * @uses \Ohtyap\ValueObject\Type\Ip
 * @uses \Ohtyap\ValueObject\Type\Ipv4
 * @uses \Ohtyap\ValueObject\Type\Ipv6
 * @uses \Ohtyap\ValueObject\Type\Url
 * @uses \Ohtyap\ValueObject\Type\Uuid
 */
class TransformerTest extends TestCase
{
    /**
     * @param class-string<ValueObjectInterface> $type
     *
     * @dataProvider provideTransformData
     */
    public function testTransform(string $type, mixed $value): void
    {
        $transformer = new Transformer();
        $valueObject = $transformer->transform($type, $value);
        self::assertSame($value, $valueObject->value());
        self::assertInstanceOf($type, $valueObject);
    }

    /**
     * @dataProvider provideTransformData
     *
     * @param class-string<ValueObjectInterface> $type
     */
    public function testDefaultHas(string $type): void
    {
        $transformer = new Transformer();
        self::assertTrue($transformer->has($type));
    }

    /**
     * @return array<array<mixed>>
     */
    public function provideTransformData(): array
    {
        return [
            [Email::class, 'example@php.net'],
            [Hostname::class, 'php.net'],
            [Ip::class, '4.4.4.4'],
            [Ipv4::class, '4.4.4.4'],
            [Ipv6::class, '2001:4860:4860::8888'],
            [Url::class, 'https://php.net'],
            [Uuid::class, '00000000-0000-0000-0000-000000000000'],
        ];
    }

    public function testInvalidTransform(): void
    {
        $this->expectException(TransformException::class);
        $transformer = new Transformer();
        /** @phpstan-ignore-next-line */
        $transformer->transform(\DateTime::class, '');
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

        $valueObject = $transformer->transform($type, ['a value']);
        self::assertSame(['a value'], $valueObject->value());
    }

    /**
     * @return array<array<mixed>>
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
     * @return array<array<mixed>>
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
