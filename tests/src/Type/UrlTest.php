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

use Ohtyap\ValueObject\Type\Url;

/**
 * @covers \Ohtyap\ValueObject\Type\Url
 * @uses \Ohtyap\ValueObject\Compare\ValueObjectCompare
 * @uses \Ohtyap\ValueObject\Convert\Convert
 */
class UrlTest extends AbstractScalarTypeTest
{
    protected string $type = Url::class;
    protected string $extraGetterMethod = 'url';

    /**
     * @return array<array<string>>
     */
    public function provideValidValues(): array
    {
        return [
            ['https://php.net', 'https://php.net'],
            ['https://www.php.net', 'https://www.php.net'],
            ['http://php.net', 'http://php.net'],
            ['http://www.php.net', 'http://www.php.net'],
            ['ftp://www.php.net', 'ftp://www.php.net'],
        ];
    }

    /**
     * @return array<array<string>>
     */
    public function provideInvalidValues(): array
    {
        return [
            [''],
            ['php.net'],
            ['www.php.net'],
            ['//www.php.net'],
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
