# php-currency

php-currency is a Laravel library for dealing with currency management.

## Installation

Use the package manager [composer](https://getcomposer.org/download/) to install php-currency.

``` bash
composer require walkerchiu/php-currency
```

## Usage

### Package settings

``` bash
# CLI

# Publish this package settings
php artisan vendor:publish

# Overwrite default settings
vi config/wk-currency.php

# Overwrite translations
cd resources/lang/vendor/php-currency
vi ...

# Overwrite views
cd resources/views/vendor/php-currency
vi ...

# See migrations
cd database/migrations
cat ...
```

### Core settings

``` bash
# CLI

# Overwrite default settings
vi config/wk-core.php

# See class section
# See table section
```

### Migrations

``` bash
# CLI

# Generate a database migration
php artisan make:migration

# Run all of your outstanding migrations
php artisan migrate

# See which migrations have run thus far
php artisan migrate:status
```

### How to use

#### Entity

In fact, this usage is not limited to Entity, and other usages such as Repository and Service are also similar.

You can view the source code to understand the methods provided by these classes.

``` php
# PHP

# Use directly
# You can find more settings in config/wk-core.php
use WalkerChiu\Currency\Models\Entities\Currency

Currency::all();
```

``` php
# PHP

# Use core setting
# You can find more settings in config/wk-core.php
use Illuminate\Support\Facades\App;

App::make(config('wk-core.class.currency.currency'));
```

#### FormRequest

``` php
# PHP

# controller

# You can find more information in Models/Forms folder
use WalkerChiu\Currency\Models\Forms\CurrencyFormRequest

/**
 * Store a newly created resource in storage.
 *
 * @param  \WalkerChiu\Currency\Models\Forms\CurrencyFormRequest  $request
 * @return \Illuminate\Http\Response
 */
public function store(CurrencyFormRequest $request)
{
    # ...
}
```

### Useful commands

``` bash
# CLI

# Truncate all tables of this package
php artisan command:CurrencyCleaner
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
