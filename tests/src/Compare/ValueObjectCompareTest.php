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

namespace Ohtyap\Test\ValueObject\Compare;

use Ohtyap\ValueObject\Compare\ValueObjectCompare;
use Ohtyap\ValueObject\ValueObjectInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ohtyap\ValueObject\Compare\ValueObjectCompare
 */
class ValueObjectCompareTest extends TestCase
{
    /**
     * @dataProvider provideCompareData
     */
    public function testCompare(string $method, bool $compare, mixed $value1, mixed $value2): void
    {
        // @phpstan-ignore-next-line
        self::assertSame($compare, ValueObjectCompare::{$method}($value1, $value2));
    }

    /**
     * @return array<array<mixed>>
     */
    public function provideCompareData(): array
    {
        return [
            [
                'stringCompare',
                true,
                new class implements ValueObjectInterface {
                    public function value(): string
                    {
                        return 'test';
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                'test',
            ],
            [
                'stringCompare',
                true,
                new class implements ValueObjectInterface {
                    public function value(): string
                    {
                        return 'test';
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                new class implements \Stringable {
                    public function __toString(): string
                    {
                        return 'test';
                    }
                },
            ],
            [
                'stringCompare',
                true,
                new class implements ValueObjectInterface {
                    public function value(): string
                    {
                        return 'test';
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                new class implements ValueObjectInterface {
                    public function value(): string
                    {
                        return 'test';
                    }
                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
            ],
            [
                'stringCompare',
                false,
                new class implements ValueObjectInterface {
                    public function value(): string
                    {
                        return 'test';
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                'notsame',
            ],
            [
                'stringCompare',
                false,
                new class implements ValueObjectInterface {
                    public function value(): string
                    {
                        return 'test';
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                new class implements \Stringable {
                    public function __toString(): string
                    {
                        return 'notsame';
                    }
                },
            ],
            [
                'stringCompare',
                false,
                new class implements ValueObjectInterface {
                    public function value(): string
                    {
                        return 'test';
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                new class implements ValueObjectInterface {
                    public function value(): string
                    {
                        return 'notsame';
                    }
                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
            ],
            [
                'stringCompare',
                false,
                new class implements ValueObjectInterface {
                    public function value(): string
                    {
                        return 'test';
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                new \DateTime(),
            ],
            [
                'stringCompare',
                false,
                new class implements ValueObjectInterface {
                    public function value(): string
                    {
                        return 'test';
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                12,
            ],

            [
                'stringCompare',
                true,
                new class implements ValueObjectInterface {
                    public function value(): string
                    {
                        return 'test';
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                'test',
            ],
            [
                'stringCompare',
                false,
                new class implements ValueObjectInterface {
                    public function value(): int
                    {
                        return 12;
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                'test',
            ],


            [
                'intCompare',
                true,
                new class implements ValueObjectInterface {
                    public function value(): int
                    {
                        return 5000;
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                5000,
            ],
            [
                'intCompare',
                true,
                new class implements ValueObjectInterface {
                    public function value(): int
                    {
                        return 5000;
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                5000.9,
            ],
            [
                'intCompare',
                true,
                new class implements ValueObjectInterface {
                    public function value(): int
                    {
                        return 5000;
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                new class implements ValueObjectInterface {
                    public function value(): int
                    {
                        return 5000;
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
            ],
            [
                'intCompare',
                false,
                new class implements ValueObjectInterface {
                    public function value(): int
                    {
                        return 5000;
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                5001,
            ],
            [
                'intCompare',
                false,
                new class implements ValueObjectInterface {
                    public function value(): int
                    {
                        return 5000;
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                'string',
            ],
            [
                'intCompare',
                false,
                new class implements ValueObjectInterface {
                    public function value(): int
                    {
                        return 5000;
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
                new class implements ValueObjectInterface {
                    public function value(): int
                    {
                        return 5001;
                    }

                    public function equals(mixed $other): bool
                    {
                        return false;
                    }
                },
            ],
        ];
    }


}
