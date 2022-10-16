<?php

namespace ItsClassified\LivewireSocialitePwa\Commands;

use Illuminate\Console\Command;

class LivewireSocialitePwaCommand extends Command
{
    public $signature = 'livewire-socialite-pwa';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
