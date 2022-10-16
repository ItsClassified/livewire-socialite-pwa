<?php

namespace ItsClassified\LivewireSocialitePwa;


use ItsClassified\LivewireSocialitePwa\Providers\AppleProvider;
use ItsClassified\LivewireSocialitePwa\Providers\GoogleProvider;

class LivewireSocialitePwa
{
    final static public function google(): GoogleProvider
    {
        return new GoogleProvider();
    }

    final static public function apple(): AppleProvider
    {
        return new AppleProvider();
    }
}
