<?php

namespace App\Livewire\Spo;

use App\Models\Spo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
#[Layout('layouts.template')]

class Index extends Component
{
        use WithPagination,WithoutUrlPagination;
    public $query='';

    public function delete($id)
{
    $surat = Spo::findOrFail($id);

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
    $user = Auth::user();

    $datasurat = Spo::query()
        ->when(
            $user->unit_id !== null,
            function ($query) use ($user) {
                $query->where('unit_id', $user->unit_id);
            },
            function ($query) {
                $query->whereNull('unit_id');
            }
        )
        ->where('nomor_surat', 'like', '%' . $this->query . '%')
        ->paginate(10);

    return view('livewire.spo.index', [
        'datasurat' => $datasurat
    ]);
}
}
