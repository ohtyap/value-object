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

use Ohtyap\Misc\ValueObject\ValueObjectWithTransformer;
use Ohtyap\ValueObject\Transformer\Schema;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ohtyap\ValueObject\Transformer\Schema
 */
class SchemaTest extends TestCase
{
    public function testSchema(): void
    {
        $properties = [
            'prop1' => ValueObjectWithTransformer::class,
            'prop2' => ValueObjectWithTransformer::class,
            'prop3' => ValueObjectWithTransformer::class,
            'prop4' => ValueObjectWithTransformer::class,
            'prop5' => ValueObjectWithTransformer::class,
        ];

        $schema = new Schema('test');
        self::assertSame('test', $schema->name());

        foreach ($properties as $name => $type) {
            $schema->addProperty($name, $type);
        }

        self::assertFalse($schema->hasProperty('propDoesNotExist'));
        foreach ($properties as $name => $type) {
            self::assertTrue($schema->hasProperty($name));
            self::assertSame($type, $schema->type($name));
        }

        $availableProps = $schema->properties();
        self::assertCount(\count($properties), $availableProps);
        foreach (\array_keys($properties) as $name) {
            self::assertContains($name, $availableProps);
        }
    }
}
