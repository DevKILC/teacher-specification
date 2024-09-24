<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class UserStatus extends Component
{
    public $user;

    public function render()
    {
        $isOnline = Cache::has('user-is-online-' . $this->user->id);
        $lastSeen = Cache::get('user-last-seen-' . $this->user->id);

        return view('livewire.user-status', [
            'isOnline' => $isOnline,
            'lastSeen' => $lastSeen,
        ]);
    }
}
