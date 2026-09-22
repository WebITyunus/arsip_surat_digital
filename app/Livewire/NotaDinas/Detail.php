<?php

namespace App\Livewire\NotaDinas;

use App\Models\NotaDinas;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]

class Detail extends Component
{
        public NotaDinas $surat;

    public function mount(NotaDinas $surat){
        $this->surat = $surat;
    }

    public function render()
    {
        return view('livewire.nota-dinas.detail');
    }
}
