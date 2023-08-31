<?php
namespace ItsClassified\LivewireSocialitePwa\Traits\Livewire\Apple;

use App\Models\User;
use \ItsClassified\LivewireSocialitePwa\Enums\SocialiteProviders;
use Laravel\Socialite\Facades\Socialite;

trait HasAppleLogin
{
    public function initializeHasAppleLogin()
    {
        // add listeren to $listeners array
        $this->listeners['loginWithAppleOnSuccess'] = 'loginWithAppleOnSuccess';

        $this->listeners['loginWithAppleFailed'] = 'loginWithAppleFailed';
        $this->listeners['loginWithAppleSuccess'] = 'loginWithAppleSuccess';
        $this->listeners['loginWithAppleValidated'] = 'loginWithAppleValidated';
    }

    public function loginWithAppleOnSuccess($data)
    {
        try {
            // Validate the token
            $http = new \GuzzleHttp\Client();

            // Go to: https://appleid.apple.com/auth/token
            $response = $http->post('https://appleid.apple.com/auth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $data['authorization']['code'],
                    'redirect_uri' => config('livewire-socialite-pwa.apple.redirect'), // TODO CHANGE
                    'client_id' => config('livewire-socialite-pwa.apple.client_id'),
                    'client_secret' => config('livewire-socialite-pwa.apple.client_secret')
                ]
            ]);

            $body = json_decode((string) $response->getBody(), true);

            $claims = explode('.', $body['id_token'])[1];
            $token = json_decode(base64_decode($claims), true);

            // If the token is valid, safe the user values in session
            session()->put('provider_user', [
                'access_token' => $body['access_token'],
                'token_type' => $body['token_type'],
                'expires_in' => $body['expires_in'],
                'refresh_token' => $body['refresh_token'],
                'id_token' => $body['id_token'],
            ]);

            session()->put('provider_type', SocialiteProviders::APPLE->value);
        } catch (\Exception $e) {
            $this->dispatch('loginWithAppleFailed', data: [
                'status' => 'error',
                'message' => 'Invalid token',
            ]);
            return;
        }


        $claims = explode('.', $body['id_token'])[1];
        $token = json_decode(base64_decode($claims), true);

        // Check if there is an account with this apple id
        $appleIdExists = User::whereHas('socialiteCredentials', function ($query) use ($token) {
            $query->where('provider_id', $token['sub'])->where('provider_name', SocialiteProviders::APPLE);
        })->first();

        if ($appleIdExists) {
            auth()->login($appleIdExists);
            $this->dispatch('loginWithAppleSuccess', data: [
                'status' => 'success',
                'message' => 'User is authenticated and logged in!',
            ]);
            return;
        }

        // Check if the email adress is already in use
        $emailExists = User::where('email', $token['email'])->first();

        if ($emailExists) {
            // Check if the user has a socilaite account that matches
            $socialiteExists = $emailExists->socialiteCredentials()
                ->where('provider_name', SocialiteProviders::APPLE)
                ->where('provider_id', $token['sub'])->first();

            if ($socialiteExists) {
                // Login the user
                auth()->login($emailExists);

                $this->dispatch('loginWithAppleSuccess', data: [
                    'status' => 'success',
                    'message' => 'User is authenticated and logged in!',
                ]);
                return;
            } else {
                $this->dispatch('loginWithAppleFailed', data: [
                    'status' => 'failed',
                    'message' => 'Email is already in use!',
                ]);
                return;
            }
        }

        $this->dispatch('loginWithAppleValidated', data: [
            'status' => 'validated',
            'message' => 'User is validated and can be send to create a username!',
        ]);
    }
}
