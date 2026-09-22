<?php

namespace App\Livewire\SuratMasuk;

use App\Models\SuratFile;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.template')]
class Create extends Component
{
    use WithFileUploads;

    #[Validate('required|date')]
    public $tanggal_diterima = '';

    #[Validate('required|date')]
    public $tanggal_surat = '';

    #[Validate('required|string|max:255')]
    public $nomor_surat = '';

    #[Validate('required|string|max:255')]
    public $asal_surat = '';

    #[Validate('required|string')]
    public $isi = '';

    #[Validate('required|string|max:255')]
    public $nomor_disposisi = '';

    #[Validate('required|string|max:255')]
    public $diteruskan = '';

    #[Validate([
        'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
    ])]
    public $lampiran = [];

protected $rules = [
    'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
];

    public function mount()
{
    $this->generateNomorSurat();
}

private function generateNomorSurat()
{
    $tahun = now()->year;
    $bulanRomawi = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII',
    ];

    $nomorTerakhir = SuratMasuk::whereYear('tanggal_surat', $tahun)
        ->get()
        ->map(function ($surat) {
            return (int) explode('/', $surat->nomor_disposisi)[0];
        })
        ->max();

    $nomorBerikutnya = ($nomorTerakhir ?? 0) + 1;

    $this->nomor_disposisi = sprintf(
        '%05d/DIS/PKU/%s/%d',
        $nomorBerikutnya,
        $bulanRomawi[now()->month],
        $tahun
    );
}
    public function SimpanSuratMasuk()
    {
        $this->validate();

        $path = null;

        try {
            DB::transaction(function () use (&$path) {
                $surat = SuratMasuk::create([
                    'tanggal_diterima' => $this->tanggal_diterima,
                    'tanggal_surat' => $this->tanggal_surat,
                    'nomor_surat' => $this->nomor_surat,
                    'asal_surat' => $this->asal_surat,
                    'isi' => $this->isi,
                    'nomor_disposisi' => $this->nomor_disposisi,
                    'diteruskan' => $this->diteruskan,
                    'author_id' => Auth::id(),
                    'editor_id' => Auth::id(),
                ]);

                foreach ($this->lampiran as $file) {

                $namaAsli = $file->getClientOriginalName();
                $namaFile = $file->hashName();

                $path = $file->storeAs(
                    'files',
                    $namaFile,
                    'public'
                );

                // Catat file yang sudah berhasil di-upload
                $uploadedPaths[] = $path;

                $surat->files()->create([
                    'nama_file' => $namaFile,
                    'nama_asli' => $namaAsli,
                    'path' => $path,
                ]);
            }
            });

        // Notifikasi berhasil
        $this->dispatch(
            'notify',
            type: 'success',
            title: 'Berhasil',
            message: 'Surat keluar berhasil disimpan.'
        );
        $this->reset();
        $this->generateNomorSurat();


        } catch (\Throwable $e) {

            if ($path) {
                Storage::disk('public')->delete($path);
            }
            report($e);
        // Notifikasi gagal
        $this->dispatch(
            'notify',
            type: 'error',
            title: 'Gagal',
            message: 'Surat gagal disimpan.'
        );
            $this->reset();
        }
    }

    public function removeLampiran($index)
{
    unset($this->lampiran[$index]);

    $this->lampiran = array_values($this->lampiran);
}

    public function render()
    {
        return view('livewire.surat-masuk.create');
    }
}
