<?php

namespace App\Livewire\Perdir;

use App\Models\Perdir;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]

class Detail extends Component
{
     public Perdir $surat;

    public function mount(Perdir $surat){
        $this->surat = $surat;
    }

    public function render()
    {
        return view('livewire.perdir.detail');
    }
}
