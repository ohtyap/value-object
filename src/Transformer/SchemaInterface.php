<?php
declare(strict_types=1);

namespace Ohtyap\ValueObject\Transformer;

use Ohtyap\ValueObject\ValueObjectInterface;

interface SchemaInterface
{
    public function name(): string;

    public function hasProperty(string $property): bool;

    /**
     * @return class-string<ValueObjectInterface>
     */
    public function type(string $property): string;

    /**
     * @return array<string>
     */
    public function properties(): array;
}
