<?php

declare(strict_types=1);

namespace Yard\Hooks;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yard\Hooks\Config\ConfigData;

class HooksServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('hooks')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->bind(HookRegistrar::class, function () {
            $config = ConfigData::from(config('hooks'));

            return new HookRegistrar($config->classNames());
        });
    }

    public function packageBooted(): void
    {
        app(HookRegistrar::class)->registerHooks();
    }
}
