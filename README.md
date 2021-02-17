# Value objects
Base library for the usage of value objects.

[![Type Coverage](https://shepherd.dev/github/ohtyap/value-object/coverage.svg)](https://shepherd.dev/github/ohtyap/value-object)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fohtyap%2Fvalue-object%2F1.x)](https://dashboard.stryker-mutator.io/reports/github.com/ohtyap/value-object/1.x)
[![Codecov](https://img.shields.io/codecov/c/github/ohtyap/value-object)](https://codecov.io/gh/ohtyap/value-object)

[![PHP from Packagist](https://img.shields.io/packagist/php-v/ohtyap/value-object)](https://packagist.org/packages/ohtyap/value-object)
[![Packagist Version](https://img.shields.io/packagist/v/ohtyap/value-object)](https://packagist.org/packages/ohtyap/value-object)
[![Packagist Version (including pre-releases)](https://img.shields.io/packagist/v/ohtyap/value-object?include_prereleases)](https://packagist.org/packages/ohtyap/value-object)


## Installation

You can install the package via composer:

```bash
composer require ohtyap/value-object
```

## A generic interface
The main purpose of this repository is to provide generic interfaces for value objects, which is especially useful if you need a (reusable) way to transform data from the outside (your framework, ORM, etc.) to your domain layer (where you want to use value objects) and vice versa.

### ValueObjectInterface

The `ValueObjectInterface` declares a class as value object. The only two necessary methods are `equals()` and `value()`.

#### `equals()`

Value objects are equal due to the value of their properties. This means the following usually won't work when working with value objects:
```php
(new ValueObject('value')) === (new ValueObject('value'));
(new ValueObject(new DateTime('2020-12-12'))) == (new ValueObject(new DateTime('2020-12-12')));
(new ValueObject('value')) == 'value';
```

`equals()` allows comparison based on the meaning of the value, not based on type or same instance of a class.

#### `value()`

This method should return the value as a type your application layer can understand. In most cases these are basic types like `int` or `string`, but also more complex types like `array`or `\DateTime` are possible.

### TransformableInterface

To convert a variable to a value object you need to transform the variable via the `TransformableInterface::transform()`.

```php
$emailValueObj = YourEmailValueObject::transform('example@php.net');
```


## Transformer
To avoid the direct usage of the `TransformableInterface`you can use the transformer instead.

```php
$transformer = new Transformer();
$emailValueObj = $transformer->transformValue(YourEmailValueObject::class, 'example@php.net');
```

Use `add()` to provide value object transformation. It is also possible to register a different transformable for a value object:
```php
$transformer = new Transformer();
$transformer->addType(YourEmailValueObject::class, CustomEmailTransformable::class);
```

In case a (reusable) way of transforming a set of values (an array) to value objects, it is possible to add a schema:
```php
$schema = new Schema('user');
$schema->addProperty('id', MyUuidValueObject::class);
$schema->addProperty('email', MyEmailValueObject::class);

$transformer = new Transformer();
$transformer->addSchema($schema);

$result = $transformer->transformBySchema('user', ['id' => 'bd24e386-754d-4a8d-8c82-9d9be47220e9', 'email' => 'example@php.net']);
```

## Testing

``` bash
composer run phpunit
composer run psalm
composer run phpstan
composer run infection
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover any security related issues, please email security@tpa.codes instead of using the issue tracker.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
