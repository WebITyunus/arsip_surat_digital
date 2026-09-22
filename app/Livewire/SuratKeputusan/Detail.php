<?php

namespace App\Livewire\SuratKeputusan;

use App\Models\SuratKeputusan;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]

class Detail extends Component
{
        public SuratKeputusan $surat;

    public function mount(SuratKeputusan $surat){
    $this->surat = $surat;
    }
    public function render()
    {
        return view('livewire.surat-keputusan.detail');
    }
}
