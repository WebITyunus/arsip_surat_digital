<?php

namespace App\Livewire\Sertifikat;

use App\Models\Sertifikat;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]

class Detail extends Component
{
        public Sertifikat $surat;

    public function mount(Sertifikat $surat){
        $this->surat = $surat;
    }

    public function render()
    {
        return view('livewire.sertifikat.detail');
    }
}
