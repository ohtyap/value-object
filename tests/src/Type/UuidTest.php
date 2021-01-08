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

use Ohtyap\ValueObject\Type\Uuid;

/**
 * @covers \Ohtyap\ValueObject\Type\Uuid
 * @uses \Ohtyap\ValueObject\Compare\ValueObjectCompare
 * @uses \Ohtyap\ValueObject\Convert\Convert
 */
class UuidTest extends AbstractScalarTypeTest
{
    protected string $type = Uuid::class;
    protected string $extraGetterMethod = 'uuid';

    /**
     * @return array<array<string>>
     */
    public function provideValidValues(): array
    {
        $values = [];
        $mutations = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];
        foreach ($mutations as $version) {
            foreach ($mutations as $variant) {
                $values[] = [
                    "3ba82ce4-a251-{$version}b68-{$variant}380-4f514bdc3a6b",
                    "3ba82ce4-a251-{$version}b68-{$variant}380-4f514bdc3a6b",
                ];
            }
        }

        $values[] = ['00000000-0000-0000-0000-000000000000', '00000000-0000-0000-0000-000000000000'];
        $values[] = ['{3ba82ce4-a251-4b68-9380-4f514bdc3a6b}', '3ba82ce4-a251-4b68-9380-4f514bdc3a6b'];
        $values[] = ['urn:uuid:3ba82ce4-a251-4b68-9380-4f514bdc3a6b', '3ba82ce4-a251-4b68-9380-4f514bdc3a6b'];

        return $values;
    }

    /**
     * @return array<array<string>>
     */
    public function provideInvalidValues(): array
    {
        return [
            [''], //empty
            ['zba82ce4-a251-4b68-9380-4f514bdc3a6b'], //not hexadecimal
            ['3ba82ce4-a251-4b68-9380-4f514bdc3a6b '], // invalid character (space) at end
            [' 3ba82ce4-a251-4b68-9380-4f514bdc3a6b'], // invalid character (space) at start
            ['3ba82ce4a2514b6893804f514bdc3a6b'], // without dash
        ];
    }

    /**
     * @return array<array<mixed>>
     */
    public function provideUnsupportedTypes(): array
    {
        return [
            [['an', 'array']],
            [12],
            [13.567546],
            [false],
            [true],
            [null]
        ];
    }
}
