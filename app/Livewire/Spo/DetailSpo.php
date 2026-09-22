<?php

namespace App\Livewire\Spo;

use App\Models\Spo;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]

class DetailSpo extends Component
{
        public Spo $surat;

    public function mount(Spo $surat){

    $this->surat = $surat;
    }
    public function render()
    {
        return view('livewire.spo.detail-spo');
    }
}
