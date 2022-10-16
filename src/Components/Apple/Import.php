<?php

namespace ItsClassified\LivewireSocialitePwa\Components\Apple;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use ItsClassified\LivewireSocialitePwa\Enums\SocialiteProviders;
use ItsClassified\LivewireSocialitePwa\Exceptions\Config\NoClientIdProvided;
use ItsClassified\LivewireSocialitePwa\Exceptions\Config\NoRedirectProvided;

class Import extends Component
{
    public function render(): View
    {
        // Check if the config values are set
        if (!config('livewire-socialite-pwa.apple.client_id')){
            throw new NoClientIdProvided(SocialiteProviders::APPLE);
        }

        if (!config('livewire-socialite-pwa.apple.redirect')){
            throw new NoRedirectProvided(SocialiteProviders::APPLE);
        }

        return view('livewire-socialite-pwa::components.apple.import');
    }
}
