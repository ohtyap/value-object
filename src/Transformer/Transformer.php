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
use Ohtyap\ValueObject\Type\Email;
use Ohtyap\ValueObject\Type\Hostname;
use Ohtyap\ValueObject\Type\Ip;
use Ohtyap\ValueObject\Type\Ipv4;
use Ohtyap\ValueObject\Type\Ipv6;
use Ohtyap\ValueObject\Type\Url;
use Ohtyap\ValueObject\Type\Uuid;
use Ohtyap\ValueObject\ValueObjectInterface;

final class Transformer implements TransformerInterface
{
    /**
     * @var array<class-string<ValueObjectInterface>, class-string<TransformableInterface>>
     */
    private array $transformers = [
        Email::class => Email::class,
        Hostname::class => Hostname::class,
        Ip::class => Ip::class,
        Ipv4::class => Ipv4::class,
        Ipv6::class => Ipv6::class,
        Url::class => Url::class,
        Uuid::class => Uuid::class,
    ];

    /**
     * @param class-string<ValueObjectInterface> $type
     * @param class-string<TransformableInterface>|null $transformable
     */
    public function add(string $type, ?string $transformable = null): void
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

    /**
     * @param class-string<ValueObjectInterface> $type
     */
    public function has(string $type): bool
    {
        return isset($this->transformers[$type]);
    }

    /**
     * @param class-string<ValueObjectInterface> $type
     */
    public function transform(string $type, mixed $value): ValueObjectInterface
    {
        if (!$this->has($type)) {
            throw new TransformException(\sprintf("Transform for type '%s' doesn't exist.", $type));
        }
        $transformer = $this->transformers[$type];

        return $transformer::transform($value);
    }
}
