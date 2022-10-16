<?php

namespace ItsClassified\LivewireSocialitePwa\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ItsClassified\LivewireSocialitePwa\LivewireSocialitePwa
 */
class LivewireSocialitePwa extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ItsClassified\LivewireSocialitePwa\LivewireSocialitePwa::class;
    }
}
