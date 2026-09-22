<?php

namespace App\Livewire\Unit;

use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
#[Layout('layouts.template')]

class Index extends Component
{


    use WithPagination, WithoutUrlPagination;

        #[Validate('required|string|max:255')]
    public $nama_unit = '';

    #[Validate('required|string|max:255')]
    public $kode_unit = '';

    public $query = '';


    public function store()
    {
        $this->validate();

        try {
            DB::transaction(function () {
             Unit::create([
                    'nama_unit' => $this->nama_unit,
                    'kode_unit' => $this->kode_unit,
                ]);

            });

        // Notifikasi berhasil
        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Berhasil',
            message: 'Unit berhasil disimpan.'
        );
        $this->reset();


        } catch (\Throwable $e) {

            report($e);
        // Notifikasi gagal
        $this->dispatch(
            'notify',
            type: 'error',
            title: 'Gagal',
            message: 'Unit gagal disimpan.'
        );
            $this->reset();
        }
    }


public function delete($id)
{
    $surat = Unit::findOrFail($id);

    $surat->delete();

     // Notifikasi berhasil
        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Berhasil',
            message: 'Surat dan file berhasil di hapus.'
        );

}
    public function updatedQuery()
    {
        $this->resetPage();
    }


    public function render()
    {
            $dataunit = Unit::query()
        ->where(function ($query) {
            $query->where('nama_unit', 'like', '%' . $this->query . '%')
                  ->orWhere('kode_unit', 'like', '%' . $this->query . '%');
        })
        ->paginate(10);
        return view('livewire.unit.index',['dataunit' => $dataunit]);
    }
}
