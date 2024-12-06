<?php

declare(strict_types=1);

namespace Yard\Hook;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HookServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('hooks')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->bind(Registrar::class, function () {
            $config = Config::from(config('hooks'));

            return new Registrar($config->classNames());
        });
    }

    public function packageBooted(): void
    {
        app(Registrar::class)->registerHooks();





















    }
}
