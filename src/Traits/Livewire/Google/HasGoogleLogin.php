<?php
namespace ItsClassified\LivewireSocialitePwa\Traits\Livewire\Google;

use App\Models\User;
use \ItsClassified\LivewireSocialitePwa\Enums\SocialiteProviders;

trait HasGoogleLogin
{
    public function initializeHasGoogleLogin()
    {
        // add listeren to $listeners array
        $this->listeners['loginWithGoogleOnSuccess'] = 'loginWithGoogleOnSuccess';

        $this->listeners['loginWithGoogleFailed'] = 'loginWithGoogleFailed';
        $this->listeners['loginWithGoogleSuccess'] = 'loginWithGoogleSuccess';
        $this->listeners['loginWithGoogleValidated'] = 'loginWithGoogleValidated';
    }

    public function loginWithGoogleOnSuccess($data = null)
    {
        try {
            $jwt = new \Firebase\JWT\JWT;
            $jwt::$leeway = 60; // adjust this value

            $client = new \Google_Client(['jwt' => $jwt, 'client_id' => config('LIVEWIRE_GOOGLE_CLIENT_ID')]);

            $userData = $client->verifyIdToken($data['credential']);
            if ($userData) {

                // the payloud is valid so we can save the user values in session
                session()->put('provider_user', [
                    'access_token' => null,
                    'token_type' => null,
                    'expires_in' => null,
                    'refresh_token' => null,
                    'id_token' => $data['credential'],
                ]);

                session()->put('provider_type', SocialiteProviders::GOOGLE->value);


            } else {
                $this->dispatch('loginWithGoogleFailed', data: [
                    'status' => 'error',
                    'message' => 'Invalid token',
                ]);
                return;
            }
        } catch (\Exception $e) {
            $this->dispatch('loginWithGoogleFailed', data: [
                'status' => 'error',
                'message' => 'Invalid token',
            ]);
            return;
        }

        // Check if there is an account with this google id
        $googleIdExists = User::whereHas('socialiteCredentials', function ($query) use ($userData) {
            $query->where('provider_id', $userData['sub'])->where('provider_name', SocialiteProviders::GOOGLE);
        })->first();

        if ($googleIdExists) {
            auth()->login($googleIdExists);
            $this->dispatch('loginWithGoogleSuccess', data: [
                'status' => 'success',
                'message' => 'User authenticated and logged in!',
            ]);
            return;
        }

        // Check if the email adress is already in use
        $emailExists = User::where('email', $userData['email'])->first();

        if ($emailExists) {
            // Check if the user has a socilaite account that matches
            $socialiteExists = $emailExists->socialiteCredentials()
                ->where('provider_name', SocialiteProviders::GOOGLE)
                ->where('provider_id', $userData['sub'])->first();

            if ($socialiteExists) {
                auth()->login($emailExists);
                // Login the user
                $this->dispatch('loginWithGoogleSuccess', data: [
                    'status' => 'success',
                    'message' => 'User authenticated and logged in!',
                ]);
                auth()->login($emailExists);
                return;
            } else {
                $this->dispatch('loginWithGoogleFailed', data: [
                    'status' => 'failed',
                    'message' => 'Email already in use.',
                ]);
                return;
            }
        }

        $this->dispatch('loginWithGoogleValidated', data: [
            'status' => 'validated',
            'message' => 'User is validated and can be send to the next page to create a username!',
        ]);
    }
}
