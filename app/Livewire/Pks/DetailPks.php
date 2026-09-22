<?php

namespace App\Livewire\Pks;

use App\Models\PKS;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]

class DetailPks extends Component
{
    public PKS $surat;

    public function mount(PKS $surat){
        $this->surat = $surat;
    }

    public function render()
    {
        return view('livewire.pks.detail-pks');
    }
}
