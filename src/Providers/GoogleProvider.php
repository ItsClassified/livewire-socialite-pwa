<?php

namespace ItsClassified\LivewireSocialitePwa\Providers;

use App\Enums\Permissions\Role;
use App\Models\Referrals\ReferralCode;
use App\Models\User;
use GuzzleHttp\Utils;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use ItsClassified\LivewireSocialitePwa\Enums\SocialiteProviders;
use ItsClassified\LivewireSocialitePwa\Exceptions\Config\NoClientIdProvided;
use ItsClassified\LivewireSocialitePwa\Exceptions\Config\NoClientSecretProvided;
use ItsClassified\LivewireSocialitePwa\Exceptions\Config\NoRedirectProvided;
use Throwable;
use Illuminate\Support\Str;

class GoogleProvider
{
    public function __construct(public $providerUser = null, public $provider= null)
    {
        if (!config('livewire-socialite-pwa.google.client_id')){
            throw new NoClientIdProvided(SocialiteProviders::GOOGLE);
        }

        if (!config('livewire-socialite-pwa.google.redirect')){
            throw new NoRedirectProvided(SocialiteProviders::GOOGLE);
        }

        if (!config('livewire-socialite-pwa.google.client_secret')){
            throw new NoClientSecretProvided(SocialiteProviders::GOOGLE);
        }

        $this->providerUser = session()->get('provider_user');
        $this->provider = session()->get('provider_type');

        if ($this->provider != SocialiteProviders::GOOGLE->value) {
            throw new \Exception('Invalid provider, expected google. Got: ' . $this->provider);
        }
    }


    final public function createUser(string $username)
    {
        // get the providerUser from the session
        $providerUser = session()->get('provider_user');

        $jwt = new \Firebase\JWT\JWT;
        $jwt::$leeway = 60; // adjust this value

        $client = new \Google_Client(['jwt' => $jwt, 'client_id' => env('GOOGLE_CLIENT_ID')]);

        $token = $client->verifyIdToken($providerUser['id_token']);

        $transaction = DB::transaction(function () use ($token, $providerUser, $username) {

            // Check if the email is already in use
            $emailExists = User::where('email', $token['email'])->exists();

            if ($emailExists) {
                return [
                    'status' => 'error',
                    'message' => 'Email already in use',
                ];
            } else {
                // Create the user
                $createdUser = User::create([
                    'name' => $username,
                    'email' => $token['email'],
                    'password' => bcrypt(\Str::random(16)),
                    'email_verified_at' => $token['email_verified']? now() : null,
                ]);

                // Create the socilaite credential
                $createdUser->socialiteCredentials()->create([
                    'provider_id' => $token['sub'],
                    'provider_name' => SocialiteProviders::GOOGLE,
                    'email' => $token['email'],
                    'email_verified' => $token['email_verified']? 1 : 0,
                    'access_token' => null,
                    'refresh_token' => null,
                    'name' => $username,
                    'nickname' => null,
                ]);

                // Clear the session
                session()->forget('provider_user');
                session()->forget('provider_type');

                return [
                    'status' => 'success',
                    'message' => 'User has been created',
                    'user' => $createdUser,
                ];
            }
        }, 5);

        return $transaction;
    }
}
