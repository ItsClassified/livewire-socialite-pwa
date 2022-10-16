<?php
namespace ItsClassified\LivewireSocialitePwa\Exceptions\Config;
use ItsClassified\LivewireSocialitePwa\Enums\SocialiteProviders;
class NoRedirectProvided extends \Exception
{
    public function __construct(SocialiteProviders $provider)
    {
        parent::__construct(
            "No redirect uri provided for {$provider->value}. Please add LIVEWIRE_{$provider->name}_REDIRECT_URI to your .env"
        );
    }
}
