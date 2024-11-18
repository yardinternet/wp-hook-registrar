# wp-hook-registrar

[![Code Style](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/format-php.yml/badge.svg?no-cache)](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/format-php.yml)
[![PHPStan](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/phpstan.yml/badge.svg?no-cache)](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/phpstan.yml)
[![Tests](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/run-tests.yml/badge.svg?no-cache)](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/run-tests.yml)
[![Code Coverage Badge](https://github.com/yardinternet/wp-hook-registrar/blob/badges/coverage.svg)](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/badges.yml)
[![Lines of Code Badge](https://github.com/yardinternet/wp-hook-registrar/blob/badges/lines-of-code.svg)](https://github.com/yardinternet/wp-hook-registrar/actions/workflows/badges.yml)

An Acorn package for WordPress Hook Registration.

## Features

- [x] Register Hooks using php attributes
- [x] Configure Hook registration using a config file
- [x] Load plugin-specific hooks only when the plugin is active

See [config](./config/hooks.php) for all configuration options.

## Requirements

- [Sage](https://github.com/roots/sage) >= 10.0
- [Acorn](https://github.com/roots/acorn) >= 4.0

## Installation

To install this package using Composer, follow these steps:

1. Add the following to the `repositories` section of your `composer.json`:

    ```json
    {
      "type": "vcs",
      "url": "git@github.com:yardinternet/wp-hook-registrar.git"
    }
    ```

2. Install this package with Composer:

    ```sh
    composer require yard/wp-hook-registrar
    ```

3. Run the Acorn WP-CLI command to discover this package:

    ```shell
    wp acorn package:discover
    ```

4. Publish the config file with:

   ```shell
   wp acorn vendor:publish --provider="Yard\Hooks\HooksServiceProvider"
   ```

5. Register all your project hooks in the published configuration file `config/hooks.php`.

## Installation in WordPress plugins

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

This package provides two Attributes `Action` and `Filter` Attributes. They can be used to register hooks instead of the
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
with the `add_action` and `add_filter` functions. Instead, the number of accepted arguments is determined by the method
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
