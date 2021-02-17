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

use Ohtyap\ValueObject\Exception\InvalidArgumentException;
use Ohtyap\ValueObject\ValueObjectInterface;

final class Schema implements SchemaInterface
{
    private string $name;

    /**
     * @var array<string, class-string<ValueObjectInterface>>
     */
    private array $properties = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @psalm-mutation-free
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param class-string<ValueObjectInterface> $type
     */
    public function addProperty(string $property, string $type): void
    {
        $this->properties[$property] = $type;
    }

    /**
     * @psalm-mutation-free
     */
    public function hasProperty(string $property): bool
    {
        return isset($this->properties[$property]);
    }

    /**
     * @throws InvalidArgumentException
     *
     * @psalm-mutation-free
     */
    public function type(string $property): string
    {
        if (!$this->hasProperty($property)) {
            throw new InvalidArgumentException(\sprintf("Property '%s' does not exist in schema '%s'.", $property, $this->name));
        }

        return $this->properties[$property];
    }

    /**
     * @psalm-mutation-free
     */
    public function properties(): array
    {
        return \array_keys($this->properties);
    }
}
