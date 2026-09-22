<?php

namespace App\Livewire\Perdir;

use App\Models\Perdir;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
#[Layout('layouts.template')]

class Index extends Component
{
         use WithPagination, WithoutUrlPagination;

    public $query = '';

        public function delete($id)
{
    $surat = Perdir::findOrFail($id);

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

    public function render()
    {
        $datasurat = Perdir::query()->where('nomor_surat','like','%' . $this->query . '%')->paginate(10);
        return view('livewire.perdir.index',['datasurat' => $datasurat]);
    }
}
