<?php

namespace App\Livewire\Pokja;

use App\Models\Pokjars;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
#[Layout('layouts.template')]
class Index extends Component
{
use WithPagination;
    public $query = '';


    public function updatedQuery()
    {
        $this->resetPage();
    }

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

public function render()
{
    $author = Auth::id();

    $pokjars = Pokjars::query()
        ->where('author_id', $author)
        ->where(function ($query) {
            $query->where('isi', 'like', '%' . $this->query . '%');
        })
        ->paginate(10);

    return view('livewire.pokja.index', [
        'pokjars' => $pokjars,
    ]);
}

}
