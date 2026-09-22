<?php

namespace App\Livewire\Pokjar;

use App\Models\Pokja;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
#[Layout('layouts.template')]
class Index extends Component
{
            use WithPagination,WithoutUrlPagination;
 #[Validate('required|string')]
    public $nama = '';
    #[Validate('required|string|max:255')]
    public $kode = '';

    public $query='';


    public function store(){
    $this->validate();

        Pokja::create([
        'nama' => $this->nama,
        'kode' => $this->kode,
        ]);

                // Notifikasi berhasil
        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Berhasil',
            message: 'Surat keluar berhasil disimpan.'
        );
    }

    public function delete($id){
           $surat = Pokja::findOrFail($id);

    $surat->delete();

     // Notifikasi berhasil
        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Berhasil',
            message: 'berhasil di hapus.'
        );
    }

        public function updatedQuery()
    {
        $this->resetPage();
    }


    public function render()
    {
         $pokjars = Pokja::query()->where('nama','like','%' . $this->query . '%')->paginate(10);
        return view('livewire.pokjar.index',['pokjars' => $pokjars]);
    }
}
