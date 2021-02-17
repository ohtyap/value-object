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

namespace Ohtyap\ValueObject\Transformer;

use Ohtyap\ValueObject\ValueObjectInterface;

interface SchemaInterface
{
    /**
     * @psalm-mutation-free
     */
    public function name(): string;

    /**
     * @psalm-mutation-free
     */
    public function hasProperty(string $property): bool;

    /**
     * @return class-string<ValueObjectInterface>
     *
     * @psalm-mutation-free
     */
    public function type(string $property): string;

    /**
     * @return array<string>
     *
     * @psalm-mutation-free
     */
    public function properties(): array;
}
