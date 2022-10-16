<?php

// config for ItsClassified/LivewireSocialitePwa
return [
    'google' => [
        'client_id' => env('LIVEWIRE_GOOGLE_CLIENT_ID'),
        'client_secret' => env('LIVEWIRE_GOOGLE_CLIENT_SECRET'),
        'redirect' => env('LIVEWIRE_GOOGLE_REDIRECT_URI'),
    ],

    'apple' => [
        'client_id' => env('LIVEWIRE_APPLE_CLIENT_ID'),
        'client_secret' => env('LIVEWIRE_APPLE_CLIENT_SECRET'),
        'redirect' => env('LIVEWIRE_APPLE_REDIRECT_URI'),
    ],
];
