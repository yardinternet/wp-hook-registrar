# wp-hook-registrar

[![Code Style](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/format-php.yml/badge.svg?no-cache)](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/format-php.yml)
[![PHPStan](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/phpstan.yml/badge.svg?no-cache)](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/phpstan.yml)
[![Tests](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/run-tests.yml/badge.svg?no-cache)](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/run-tests.yml)
[![Code Coverage Badge](https://github.com/yardinternet/wp-hook-registrar/blob/badges/coverage.svg)](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/badges.yml)
[![Lines of Code Badge](https://github.com/yardinternet/wp-hook-registrar/blob/badges/lines-of-code.svg)](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/badges.yml)

Register Hooks using php attributes.

## Installation

Install this package with Composer:

    ```sh
    composer require yard/wp-hook-registrar
    ```

## Usage

To use this package in a standard WordPress plugin, you can use the `HookRegistrar` to register hooks.
You can skip step 3 and 4 from the installation instructions above and instead add the following to your plugin's
main file:

```php
/**
 * Plugin Name: My Plugin
 */

require __DIR__ . '/vendor/autoload.php';

$classNames = [
    \Plugin\ClassContainsHooks::class,
    \Plugin\AnotherClassContainsHooks::class,
];

$registrar = new \Yard\Hook\Registrar($classNames);
$registrar->registerHooks();
```

## Hook Attributes

This package provides two Attributes: `Action` and `Filter`. They can be used to register hooks instead of the
WordPress functions [add_action()](https://developer.wordpress.org/reference/functions/add_action/) and [add_filter()](https://developer.wordpress.org/reference/functions/add_filter/)

This syntax allows you to place the hook registration directly above the method it invokes when the hook is triggered.

```php
#[Action(string $hookName, int $priority = 10)]
public function doSomething(): void
```

```php
#[Filter(string $hookName, int $priority = 10)]
public function filterSomething(): mixed
```

Notice that you do not need to pass the number of accepted arguments to the `Action` and `Filter` attributes as you would
with `add_action()` and `add_filter()`. Instead, the number of accepted arguments is determined by the method
signature.

You can add as many hooks to the same method as you want.

## Example

```php
<?php

namespace App\Hooks;

use Yard\Hook\Action;
use Yard\Hook\Filter;

class Theme
{
    #[Action('save_post')]
    public function doSomething(int $postId, \WP_Post $post, bool $update): string
    {
        // do something
    }

    #[Filter('the_content')]
    #[Filter('the_excerpt')]
    public function filterSomething(string $content)
    {
        // filter content
        return $content;
    }
}
```
