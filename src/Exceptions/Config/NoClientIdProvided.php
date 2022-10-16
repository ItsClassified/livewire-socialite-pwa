<?php
namespace ItsClassified\LivewireSocialitePwa\Exceptions\Config;

use ItsClassified\LivewireSocialitePwa\Enums\SocialiteProviders;

class NoClientIdProvided extends \Exception
{
    public function __construct(SocialiteProviders $provider)
    {
        parent::__construct(
            "No Client ID provided for {$provider->value}. Please add LIVEWIRE_{$provider->name}_CLIENT_ID to your .env"
        );
    }
}
