<?php

namespace App\Livewire\Pokjars;

use App\Models\Pokja;
use App\Models\Pokjars;
use App\Models\SuratFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
#[Layout('layouts.template')]
class Update extends Component
{
     use WithFileUploads;

public Pokjars $pokja;

public $tanggal_surat;
public $isi;
public $pokja_id;
public $author_id;
public $lampiran = [];



public function mount(Pokjars $pokja)
{
    $this->pokja = $pokja->load('files');

    $this->tanggal_surat = $pokja->tanggal_surat;
    $this->isi = $pokja->isi;
    $this->pokja_id = $pokja->pokja_id;
    $this->author_id = $pokja->author->name ?? '-';

}


public function UpdatePokja()
{
    // Validasi
    $this->validate([
        'tanggal_surat' => 'required|date',
        'isi' => 'required|string',
        'lampiran' => 'nullable|array',
        'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
    ]);


    $uploadedPaths = [];

    try {

        DB::transaction(function ()  use (&$uploadedPaths) {

            $this->pokja->update([
                'tanggal_surat' => $this->tanggal_surat,
                'isi' => $this->isi,
                'pokja_id' => $this->pokja_id,
            ]);
foreach ($this->lampiran as $file) {

    $path = $file->store('surat/pokjars', 'public');

$uploadedPaths[] = $path;

    SuratFile::create([
        'fileable_type' => Pokjars::class,
        'fileable_id' => $this->pokja->id,
        'nama_file' => $file->hashName(),
        'nama_asli' => $file->getClientOriginalName(),
        'path' => $path,
    ]);
}

        });

        // Notifikasi berhasil
        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Berhasil',
            message: 'Surat keluar berhasil di Update.'
        );


          // Refresh data surat beserta files
        $this->pokja->refresh();
        $this->pokja->load('files');
            // Kosongkan daftar file baru
        $this->lampiran = [];


    } catch (\Throwable $e) {

      // Hapus file yang sudah terlanjur masuk Storage
        foreach ($uploadedPaths as $path) {
            Storage::disk('public')->delete($path);
        }

        report($e);


        // Notifikasi gagal
        $this->dispatch(
            'notify',
            type: 'error',
            title: 'Gagal',
            message: 'Surat gagal di Update.'
        );
    }
}

public function hapusFile($fileId)
{
    $file = SuratFile::where('id', $fileId)
        ->where('fileable_id', $this->pokja->id)
        ->where('fileable_type', Pokjars::class)
        ->firstOrFail();

    if ($file->path) {
        Storage::disk('public')->delete($file->path);
    }

    $file->delete();

    // Jangan set $this->pokja = null
    $this->pokja->load('files');
}

    public function removeLampiran($index)
{
    unset($this->lampiran[$index]);

    $this->lampiran = array_values($this->lampiran);
}

public function render()
{
    return view('livewire.pokjars.update', [
        'pokjas' => Pokja::orderBy('nama')->get(),
    ]);
}
}
