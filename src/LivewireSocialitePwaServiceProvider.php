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
            ->hasViewComponents('livewire-socialite-google', \ItsClassified\LivewireSocialitePwa\Components\Google\Import::class)
            ->hasViewComponents('livewire-socialite-google', \ItsClassified\LivewireSocialitePwa\Components\Google\Button::class)
            ->hasViewComponents('livewire-socialite-apple', \ItsClassified\LivewireSocialitePwa\Components\Apple\Import::class)
            ->hasViewComponents('livewire-socialite-apple', \ItsClassified\LivewireSocialitePwa\Components\Apple\Button::class)
            ->hasMigration('create_livewire-socialite-pwa_table')
            ->hasCommand(LivewireSocialitePwaCommand::class);
    }
}
