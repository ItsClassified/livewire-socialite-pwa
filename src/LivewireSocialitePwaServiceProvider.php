<?php

namespace ItsClassified\LivewireSocialitePwa;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use ItsClassified\LivewireSocialitePwa\Commands\LivewireSocialitePwaCommand;

class LivewireSocialitePwaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('livewire-socialite-pwa')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_livewire-socialite-pwa_table')
            ->hasCommand(LivewireSocialitePwaCommand::class);
    }
}
