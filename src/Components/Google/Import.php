<?php

namespace ItsClassified\LivewireSocialitePwa\Components\Google;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Import extends Component
{
    public function render(): View
    {
        return view('livewire-socialite-pwa::components.google.import');
    }
}
