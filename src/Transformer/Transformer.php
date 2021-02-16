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

use Ohtyap\ValueObject\Exception\TransformException;
use Ohtyap\ValueObject\TransformableInterface;
use Ohtyap\ValueObject\ValueObjectInterface;

final class Transformer implements TransformerInterface
{
    /**
     * @var array<class-string<ValueObjectInterface>, class-string<TransformableInterface>>
     */
    private array $transformers = [];

    /**
     * @var array<string, SchemaInterface>
     */
    private array $schemas = [];

    /**
     * @param class-string<ValueObjectInterface> $type
     * @param class-string<TransformableInterface>|null $transformable
     */
    public function addType(string $type, ?string $transformable = null): void
    {
        if (!\class_exists($type)) {
            throw new TransformException(\sprintf("Can't load value object '%s'.", $type));
        }
        /** @var array<class-string, class-string> $typeImplements */
        $typeImplements = \class_implements($type);

        if (!isset($typeImplements[ValueObjectInterface::class])) {
            throw new TransformException(\sprintf("Given type '%s' doesn't implement '%s'.", $type, ValueObjectInterface::class));
        }

        if ($transformable === null) {
            if (!isset($typeImplements[TransformableInterface::class])) {
                throw new TransformException(\sprintf("Given type '%s' doesn't implement '%s'.", $type, TransformableInterface::class));
            }
            /** @var class-string<TransformableInterface> $transformable */
            $transformable = $type;
        } else {
            if (!\class_exists($transformable)) {
                throw new TransformException(\sprintf("Can't load transformable '%s'.", $transformable));
            }
            /** @var array<class-string, class-string> $transformableImplements */
            $transformableImplements = \class_implements($transformable);

            if (!isset($transformableImplements[TransformableInterface::class])) {
                throw new TransformException(\sprintf("Given class '%s' doesn't implement '%s'.", $transformable, TransformableInterface::class));
            }
        }

        $this->transformers[$type] = $transformable;
    }

    public function addSchema(SchemaInterface $schema): void
    {
        $this->schemas[$schema->name()] = $schema;
    }

    /**
     * @param class-string<ValueObjectInterface> $type
     */
    public function hasType(string $type): bool
    {
        return isset($this->transformers[$type]);
    }

    public function hasSchema(string $schema): bool
    {
        return isset($this->schemas[$schema]);
    }

    /**
     * @param class-string<ValueObjectInterface> $type
     */
    public function transformValue(string $type, mixed $value): ValueObjectInterface
    {
        if (!$this->hasType($type)) {
            throw new TransformException(\sprintf("Transform for type '%s' doesn't exist.", $type));
        }

        $transformer = $this->transformers[$type];

        return $transformer::transform($value);
    }

    public function transform(string $schemaName, array $values): array
    {
        if (!$this->hasSchema($schemaName)) {
            throw new TransformException(\sprintf('Schema with name \'%s\' does not exist.', $schemaName));
        }

        $schema = $this->schemas[$schemaName];

        $result = [];
        foreach ($schema->properties() as $property) {
            if (!\array_key_exists($property, $values)) {
                continue;
            }

            $result[$property] = $this->transformValue($schema->type($property), $values[$property]);
        }

        return $result;
    }
}
