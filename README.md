# Set of routes to manage your data in E2E tests

[![Latest Version on Packagist](https://img.shields.io/packagist/v/canvural/laravel-e2e-routes.svg?style=flat-square)](https://packagist.org/packages/canvural/laravel-e2e-routes)
![Run tests](https://github.com/canvural/laravel-e2e-routes/workflows/Run%20tests/badge.svg?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/canvural/laravel-e2e-routes.svg?style=flat-square)](https://packagist.org/packages/canvural/laravel-e2e-routes)


This package provides a set of rules to help you manage your database state when running your E2E tests using Eloquent model factories.
## Installation

You can install the package via composer:

```bash
composer require canvural/laravel-e2e-routes
```

If you wish to customize some options, you may publish the config file with

```bash
php artisan vendor:publish --provider="Vural\E2ERoutes\E2ERoutesServiceProvider"
```

This is the published config files contents. Here you can customize the route prefix which will be added to all the provided routes.Route names, and the namespace that all your models live in.
```php
<?php

return [
    'prefix' => 'e2e',
    'name' => 'e2e-routes',
    'modelNamespace' => 'App\\',
];

```

## Usage

For obvious reasons this package does not exposes the routes in the `production` environment. In other environments you can use the routes.

#### Reset database (GET `e2e/reset`)

You can use the `http://localhost/e2e/reset` route to reset your database. Under the hood this route makes a call to `migrate:refresh` Artisan command. Also if you wish to `seed` your database after migrating, you may call the route with `seed` query string attached. `http://localhost/e2e/reset?seed` 

#### Creating models (POST `e2e/{modelName}`)

This package uses your Eloquent model factories to create the data.

So, for example if you have a model called `User` and the associated `UserFactory` you can make a POST request to the `http://localhost/e2e/user` endpoint to create a `User` in your database. Also, newly created model will be returned as a response from the endpoint.

You can substitute `user` in the above example with any model you want. If the given model is not found, a `404` response will be returned. Also, if the model exists but a factory for that model does not exists a `404` response will be returned.

#### Overwriting attributes

Like the `factory` method, this package also provides you an ability to overwrite models attributes. Simply add a body to your request like so:

```php
[
    'attributes' => [ 'name' => 'John Doe' ]
]
```
This will overwrite the `name` attribute.

#### Creating many models

You can specify how many model you want to create with
```php
[
    'times' => 3
]
```
This will return an array containing 3 models.

#### Using states
If you defined some states for your factories, you can use them when you are making the request.

```php
[
    'states' => ['withAddress']
]
```
This will create your model with the `withAddress` state. If the given state is not endpoint will return a `404` response.

#### All together
```php
[
    'attributes' => [
        'name' => 'John Doe',
    ],
    'states' => ['withAddress'],
    'times' => 2
]
```
You can also combine the options like this.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email can.vural@aequitas-group.pl instead of using the issue tracker.

## Credits

- [Can Vural](https://github.com/CanVural)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
