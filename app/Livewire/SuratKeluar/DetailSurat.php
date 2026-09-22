<?php

namespace App\Livewire\SuratKeluar;

use App\Models\SuratKeluar;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]

class DetailSurat extends Component
{

    public SuratKeluar $surat;

    public function mount(SuratKeluar $surat){
    $this->surat = $surat;
    }
    public function render()
    {
        return view('livewire.surat-keluar.detail-surat');
    }
}
