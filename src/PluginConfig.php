<?php

declare(strict_types=1);

namespace Yard\Hooks;

class PluginConfig
{
    /**
     * @param string $path
     * @param array<int, class-string> $classNames
     */
    public function __construct(
        public string $path,
        public array $classNames = [],
    ) {
    }

    /**
     * @param array<string, mixed> $config
     */
    public static function from(string $path, array $config = []): self
    {
        return new self(
            $path,
            $config['classNames'] ?? [],
        );
    }

    /**
     * @param array<string, mixed> $plugins
     *
     * @return array<int, self>
     */
    public static function collect(array $plugins = []): array
    {
        return collect($plugins)
            ->map(fn (array $config, string $path) => self::from($path, $config))
            ->values()
            ->toArray();
    }
}
