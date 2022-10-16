<?php

namespace ItsClassified\LivewireSocialitePwa\Components\Google;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use ItsClassified\LivewireSocialitePwa\Enums\SocialiteProviders;
use ItsClassified\LivewireSocialitePwa\Exceptions\Config\NoClientIdProvided;
use ItsClassified\LivewireSocialitePwa\Exceptions\Config\NoClientSecretProvided;
use ItsClassified\LivewireSocialitePwa\Exceptions\Config\NoRedirectProvided;

class Button extends Component
{
    public function render(): View
    {
        // Check if the config values are set
        if (!config('livewire-socialite-pwa.google.client_id')){
            throw new NoClientIdProvided(SocialiteProviders::GOOGLE);
        }

        if (!config('livewire-socialite-pwa.google.redirect')){
            throw new NoRedirectProvided(SocialiteProviders::GOOGLE);
        }

        if (!config('livewire-socialite-pwa.google.client_secret')){
            throw new NoClientSecretProvided(SocialiteProviders::GOOGLE);
        }

        return view('livewire-socialite-pwa::components.google.button');
    }
}
