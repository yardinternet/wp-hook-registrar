<?php

declare(strict_types=1);

namespace Yard\Hook;

use Illuminate\Support\Collection;

class Config
{
	/**
	 * @param array<int, class-string> $classNames
	 * @param array<int, PluginConfig> $plugins
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
			PluginConfig::collect($config['plugins'] ?? []),
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
			->map(fn (PluginConfig $plugin) => $plugin->classNames)
			->flatten();
	}

	/**
	 * @return Collection<int, PluginConfig>
	 */
	private function activePlugins(): Collection
	{
		if (! function_exists('is_plugin_active')) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		return collect($this->plugins)
			->filter(function (PluginConfig $plugin) {
				return is_plugin_active($plugin->path);
			});
	}
}
