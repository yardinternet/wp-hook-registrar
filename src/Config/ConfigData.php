<?php

declare(strict_types=1);

namespace Yard\Hooks\Config;

use Illuminate\Support\Collection;

class ConfigData
{
    /**
     * @param array<int, class-string> $classNames
     * @param array<int, PluginData> $plugins
     */
    public function __construct(public array $classNames = [], public array $plugins = [])
    {
    }

    /**
     * @param array<string, mixed> $config
     */
    public static function from(array $config): self
    {
        return new self(
            $config['classNames'] ?? [],
            PluginData::collect($config['plugins'] ?? []),
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

    /**
     * @return Collection<int, class-string>
     */
    private function pluginClassnames(): Collection
    {
        if (count($this->plugins) === 0) {
            return collect();
        }

        return $this->activePlugins()
            ->map(fn (PluginData $plugin) => $plugin->classNames)
            ->flatten();
    }

    /**
     * @return Collection<int, PluginData>
     */
    private function activePlugins(): Collection
    {
        return collect($this->plugins)
            ->filter(function (PluginData $plugin) {
                return \is_plugin_active($plugin->path);
            });
    }
}
