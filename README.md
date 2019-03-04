# UResponse

A simple library of HTTP Responses

## Installation

Via composer:

```sh
composer require em4nl/uresponse
```

## Usage

Assuming you're using autoloading and your composer vendor dir is
at `./vendor`:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Em4nl\U;

// send a 200 response
U\ok('hello, world!');

// 404
U\not_found('this page exists not :(');

// 301
U\moved_permanently('https://example.com/');

// 302
U\found('https://example.com/');
```

## Development

Install dependencies

```sh
composer install
```

Run tests

```sh
./vendor/bin/phpunit tests
```

## License

[The MIT License](https://github.com/em4nl/uresponse/blob/master/LICENSE)
