<?php

namespace App\Livewire\Unit;

use App\Models\Unit;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.template')]
class Update extends Component
{
    public Unit $unit;
    public $nama_unit='';
    public $kode_unit='';

    public function mount(Unit $unit){
        $this->nama_unit= $unit->nama_unit;
        $this->kode_unit= $unit->kode_unit;
    }

    public function update(){
        $data=[
    'nama_unit' => $this->nama_unit,
    'kode_unit' => $this->kode_unit
        ];
        $this->unit->update($data);

                // Notifikasi berhasil
        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Berhasil',
            message: 'Unit berhasil disimpan.'
        );

    }


    public function render()
    {
        return view('livewire.unit.update');
    }
}
