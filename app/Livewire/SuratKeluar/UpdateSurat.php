<?php

namespace App\Livewire\SuratKeluar;

use App\Models\SuratFile;
use App\Models\SuratKeluar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
#[Layout('layouts.template')]

class UpdateSurat extends Component
{

    use WithFileUploads;

public SuratKeluar $surat;

public $nomor_surat;
public $tanggal_surat;
public $tujuan_surat;
public $isi;
public $author_id;
public $lampiran = [];



public function mount(SuratKeluar $surat)
{
    $this->surat = $surat->load('files');

    $this->nomor_surat = $surat->nomor_surat;
    $this->tanggal_surat = $surat->tanggal_surat;
    $this->tujuan_surat = $surat->tujuan_surat;
    $this->isi = $surat->isi;
    $this->author_id = $surat->author->name ?? '-';

}


public function UpdateSuratKeluar()
{
    // Validasi
    $this->validate([
        'tanggal_surat' => 'required|date',
        'nomor_surat' => 'required|string|max:255',
        'tujuan_surat' => 'required|string|max:255',
        'isi' => 'required|string',
        'lampiran' => 'nullable|array',
        'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
    ]);


    $uploadedPaths = [];

    try {

        DB::transaction(function ()  use (&$uploadedPaths) {

            $this->surat->update([
                'tanggal_surat' => $this->tanggal_surat,
                'nomor_surat' => $this->nomor_surat,
                'tujuan_surat' => $this->tujuan_surat,
                'isi' => $this->isi,
            ]);
foreach ($this->lampiran as $file) {

    $path = $file->store('surat-keluar', 'public');

$uploadedPaths[] = $path;

    SuratFile::create([
        'fileable_type' => SuratKeluar::class,
        'fileable_id' => $this->surat->id,
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
        $this->surat->refresh();
        $this->surat->load('files');
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
        ->where('fileable_id', $this->surat->id)
        ->where('fileable_type', SuratKeluar::class)
        ->firstOrFail();

    if ($file->path) {
        Storage::disk('public')->delete($file->path);
    }

    $file->delete();

    // Jangan set $this->surat = null
    $this->surat->load('files');
}

    public function removeLampiran($index)
{
    unset($this->lampiran[$index]);

    $this->lampiran = array_values($this->lampiran);
}

    public function render()
    {
        return view('livewire.surat-keluar.update-surat');
    }
}
