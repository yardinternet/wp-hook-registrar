<?php

declare(strict_types=1);

namespace Yard\Hooks\Console;

use Illuminate\Console\Command;
use Yard\Hooks\Facades\Hooks;

class HooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hooks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'My custom Acorn command.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info(
            Hooks::getQuote()
        );
    }
}
