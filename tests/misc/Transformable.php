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

namespace Ohtyap\Misc\ValueObject;

use Ohtyap\ValueObject\TransformableInterface;
use Ohtyap\ValueObject\ValueObjectInterface;

final class Transformable implements TransformableInterface
{

    public static function transform(mixed $value): ValueObjectInterface
    {
        return new ValueObjectWithoutTransformer($value);
    }
}
