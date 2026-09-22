<?php

namespace App\Livewire\Pokjar;

use App\Models\Pokja;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]
class Update extends Component
{
    public Pokja $pokja;

    public $nama='';
    public $kode='';
    public function mount(Pokja $pokja){
        $this->nama=$pokja->nama;
        $this->kode=$pokja->kode;
    }
    public function update(){
        $data=([
        'nama' => $this->nama,
        'kode' => $this->kode
        ]);

        $this->pokja->update($data);
            // Notifikasi berhasil
        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Berhasil',
            message: 'Pokjar di Update.'
        );

    }
    public function render()
    {
        return view('livewire.pokjar.update');
    }
}
