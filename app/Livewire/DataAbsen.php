<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Absensi;

class DataAbsen extends Component
{
    public function render()
    {
        return view('livewire.data-absen', [
            'absen' => Absensi::all()
        ]);
    }
}
