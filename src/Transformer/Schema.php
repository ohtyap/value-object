<?php
declare(strict_types=1);

namespace Ohtyap\ValueObject\Transformer;

use Ohtyap\ValueObject\ValueObjectInterface;

class Schema implements SchemaInterface
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

    public function hasProperty(string $property): bool
    {
        return isset($this->properties[$property]);
    }

    public function type(string $property): string
    {

        return $this->properties[$property];
    }

    public function properties(): array
    {
        return \array_keys($this->properties);
    }
}
