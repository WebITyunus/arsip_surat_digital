<?php

namespace App\Livewire\Pokjars;

use App\Models\Pokja;
use App\Models\Pokjars;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
#[Layout('layouts.template')]
class Index extends Component
{
     use WithPagination, WithoutUrlPagination;

    public $pokja_id = null;
public $query = '';

        public function delete($id)
{
    $surat = Pokjars::findOrFail($id);

    // Ambil semua file yang berhubungan dengan surat
    $files = $surat->files()->get();

    foreach ($files as $file) {

        // Hapus file fisik
        if ($file->path && Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        // Hapus metadata file
        $file->delete();
    }

    // Hapus surat
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
    public function filterPokja($pokjaId)
{
    $this->pokja_id = $pokjaId;

    $this->resetPage();
}
public function resetFilter()
{
    $this->pokja_id = null;

    $this->resetPage();
}
public function render()
{
    $query = Pokjars::query()
        ->with(['author', 'pokjars']);

    if ($this->pokja_id) {
        $query->where('pokja_id', $this->pokja_id);
    }

    if ($this->query) {
        $query->where('isi', 'like', '%' . $this->query . '%');
    }

    $pokjars = $query->paginate(10);

    $dataPokja = Pokja::all();

    return view('livewire.pokjars.index', [
        'pokjars' => $pokjars,
        'dataPokja' => $dataPokja,
    ]);
}
}
