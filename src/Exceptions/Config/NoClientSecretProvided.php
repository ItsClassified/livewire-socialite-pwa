<?php
namespace ItsClassified\LivewireSocialitePwa\Exceptions\Config;
use ItsClassified\LivewireSocialitePwa\Enums\SocialiteProviders;
class NoClientSecretProvided extends \Exception
{
    public function __construct(SocialiteProviders $provider)
    {
        parent::__construct(
            "No client secret provided for {$provider->value}. Please add LIVEWIRE_{$provider->name}_CLIENT_SECRET to your .env"
        );
    }
}
