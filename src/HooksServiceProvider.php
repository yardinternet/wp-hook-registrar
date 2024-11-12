<?php

declare(strict_types=1);

namespace Yard\Hooks;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
        $this->app->singleton(HookRegistrar::class, fn () => new HookRegistrar(config('hooks.classNames')));
    }

    public function packageBooted(): void
    {
        app(HookRegistrar::class)->registerHooks();
    }
}
