<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Permintaan;
use Illuminate\Support\Facades\Auth;

class NotifPermintaanComponent extends Component
{
    public $cek;
    public function mount()
    {
        if (Auth::user()->level == 'user') {
            $data = Permintaan::whereNotNull('status')->whereNull('terbaca_user')->where('user_id', Auth::user()->id)->count();
        } else {
            $data = Permintaan::whereNull('status')->whereNull('terbaca_pengurus')->count();
        }
        if ($data != 0) {
            $this->cek = "ada";
        }
    }
    public function render()
    {
        return view('livewire.notif-permintaan-component');
    }
}
