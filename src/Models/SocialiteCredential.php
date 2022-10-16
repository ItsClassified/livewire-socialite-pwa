<?php

namespace ItsClassified\LivewireSocialitePwa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use ItsClassified\LivewireSocialitePwa\Enums\SocialiteProviders;

/**
 * Class SocialiteCredential
 *
 * @property int $id
 * @property int $user_id
 * @property string $email
 * @property string $email_verified
 * @property string $access_token
 * @property string $refresh_token
 * @property string $provider_id
 * @property string $provider_name
 * @property string $name
 * @property string $nickname
 *
 * @property User $user
 *
 */
class SocialiteCredential extends Model
{
    protected $guarded = [];

    protected $casts = [
        'provider_name' => SocialiteProviders::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
