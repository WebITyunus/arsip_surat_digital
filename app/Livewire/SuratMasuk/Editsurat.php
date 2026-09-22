<?php

namespace App\Livewire\Suratmasuk;

use App\Models\SuratFile;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.template')]
class Editsurat extends Component
{
    use WithFileUploads;

public SuratMasuk $surat;

public $nomor_surat;
public $tanggal_surat;
public $asal_surat;
public $isi;
public $nomor_disposisi;
public $diteruskan;
public $tanggal_diterima;

public $lampiran = [];

public function mount(SuratMasuk $surat)
{
    $this->surat = $surat->load('files');

    $this->nomor_surat = $surat->nomor_surat;
    $this->tanggal_surat = $surat->tanggal_surat;
    $this->asal_surat = $surat->asal_surat;
    $this->isi = $surat->isi;
    $this->nomor_disposisi = $surat->nomor_disposisi;
    $this->diteruskan = $surat->diteruskan;
    $this->tanggal_diterima = $surat->tanggal_diterima;
}


public function UpdateSuratMasuk()
{
    // Validasi
    $this->validate([
        'tanggal_diterima' => 'required|date',
        'tanggal_surat' => 'required|date',
        'nomor_surat' => 'required|string|max:255',
        'asal_surat' => 'required|string|max:255',
        'isi' => 'required|string',
        'nomor_disposisi' => 'required|string|max:255',
        'diteruskan' => 'required|string|max:255',
        'lampiran' => 'nullable|array',
        'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
    ]);


    $uploadedPaths = [];

    try {

        DB::transaction(function ()  use (&$uploadedPaths) {

            $this->surat->update([
                'tanggal_diterima' => $this->tanggal_diterima,
                'tanggal_surat' => $this->tanggal_surat,
                'nomor_surat' => $this->nomor_surat,
                'asal_surat' => $this->asal_surat,
                'isi' => $this->isi,
                'nomor_disposisi' => $this->nomor_disposisi,
                'diteruskan' => $this->diteruskan,
                'editor_id' => Auth::id(),
            ]);
foreach ($this->lampiran as $file) {

    $path = $file->store('files', 'public');

$uploadedPaths[] = $path;

    SuratFile::create([
        'fileable_type' => SuratMasuk::class,
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
        ->where('fileable_type', SuratMasuk::class)
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
        return view('livewire.surat-masuk.editsurat');
    }
}
