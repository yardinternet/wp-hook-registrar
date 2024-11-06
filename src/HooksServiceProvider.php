<?php

declare(strict_types=1);

namespace Yard\Hooks;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yard\Hooks\Console\HooksCommand;

class HooksServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('hooks')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(HooksCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton('Hooks', fn () => new Hooks($this->app));
    }

    public function packageBooted(): void
    {
        $this->app->make('Hooks');
    }
}
