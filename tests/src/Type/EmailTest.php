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

use Ohtyap\ValueObject\Type\Email;

/**
 * @covers \Ohtyap\ValueObject\Type\Email
 * @uses \Ohtyap\ValueObject\Compare\ValueObjectCompare
 * @uses \Ohtyap\ValueObject\Convert\Convert
 */
class EmailTest extends AbstractScalarTypeTest
{
    protected string $type = Email::class;
    protected string $extraGetterMethod = 'email';

    /**
     * @return array<array<string>>
     */
    public function provideValidValues(): array
    {
        return [
            ['example@php.net', 'example@php.net'],
            ['noreply@amazon.co.uk', 'noreply@amazon.co.uk'],
            ['example_with_underscore@php.net', 'example_with_underscore@php.net'],
            ['example+with+plus@php.net', 'example+with+plus@php.net'],
        ];
    }

    /**
     * @return array<array<string>>
     */
    public function provideInvalidValues(): array
    {
        return [
            [''],
            ['string'],
            ['user  name@php.net'],
            ['endingdot.@amazon.co.uk'],
            ['.startingdot@php.net'],
            ['one@two@amazon.co.uk'],
            ['(invalid@php.net'],
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
