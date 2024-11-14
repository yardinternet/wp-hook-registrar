<?php

declare(strict_types=1);

namespace Yard\Hooks;

use Illuminate\Support\Collection;

class ConfigData
{
    /**
     * @param array<int, class-string> $classNames
     * @param array<string, array<int, class-string>> $plugins
     */
    public function __construct(public array $classNames = [], public array $plugins = [])
    {
    }
    
    public static function from(array $config): self
    {
        return new self(
            $config['classNames'] ?? [],
            $config['plugins'] ?? [],
        );
    }

    /**
     * @return array<class-string>
     */
    public function classNames(): array
    {
        return collect($this->classNames)
            ->merge($this->pluginClassnames())
            ->toArray();
    }

    private function pluginClassnames(): Collection
    {
        return $this->activePlugins()
            ->flatMap(function (array $classNames) {
                return $classNames;
            });
    }

    private function activePlugins(): Collection
    {
        return collect($this->plugins)
            ->filter(function (array $classNames, string $plugin) {
                return \is_plugin_active($plugin);
            });
    }
}
