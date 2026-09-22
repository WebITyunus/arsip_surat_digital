<?php

namespace App\Livewire\SuratMasuk;

use App\Models\SuratMasuk;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]
class DetailSurat extends Component
{
    public SuratMasuk $surat;
    public function mount(SuratMasuk $surat)
    {
        $this->surat = $surat;
    }

    public function render()
    {
        return view('livewire.surat-masuk.detail-surat');
    }
}
