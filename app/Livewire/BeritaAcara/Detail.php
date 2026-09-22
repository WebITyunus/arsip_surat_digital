<?php

namespace App\Livewire\BeritaAcara;

use App\Models\BeritaAcara;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]
class Detail extends Component
{
    public BeritaAcara $surat;
    public function mount(BeritaAcara $surat){
    $this->surat = $surat;
    }
    public function render()
    {
        return view('livewire.berita-acara.detail');
    }
}
