<?php

namespace App\Livewire\SuratEdaran;

use App\Models\SuratEdaran;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]

class DetailEdaran extends Component
{
    public SuratEdaran $surat;

    public function mount(SuratEdaran $surat){
        $this->surat = $surat;
    }
    public function render()
    {
        return view('livewire.surat-edaran.detail-edaran');
    }
}
