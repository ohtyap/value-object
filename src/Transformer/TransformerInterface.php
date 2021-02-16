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

interface TransformerInterface
{
    /**
     * @param class-string<ValueObjectInterface> $type
     */
    public function hasType(string $type): bool;

    /**
     * @param class-string<ValueObjectInterface> $type
     */
    public function transformValue(string $type, mixed $value): ValueObjectInterface;

    public function hasSchema(string $schema): bool;

    /**
     * @param array<string, mixed> $values
     *
     * @return array<string, ValueObjectInterface>
     */
    public function transformBySchema(string $schemaName, array $values): array;


}
