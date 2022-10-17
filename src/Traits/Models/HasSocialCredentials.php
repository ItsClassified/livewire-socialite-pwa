<?php
namespace ItsClassified\LivewireSocialitePwa\Traits\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use \ItsClassified\LivewireSocialitePwa\Enums\SocialiteProviders;
use ItsClassified\LivewireSocialitePwa\Models\SocialiteCredential;

trait HasSocialCredentials
{
    public function initializeHasSocialCredentials()
    {

    }

    public function socialiteCredentials(): HasMany
    {
        return $this->hasMany(SocialiteCredential::class);
    }

}
