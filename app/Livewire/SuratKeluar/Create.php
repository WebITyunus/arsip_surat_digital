<?php

namespace App\Livewire\SuratKeluar;

use App\Models\SuratFile;
use App\Models\SuratKeluar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
#[Layout('layouts.template')]

class Create extends Component
{
        use WithFileUploads;

    #[Validate('required|date')]
    public $tanggal_surat = '';

    #[Validate('required|string|max:255')]
    public $nomor_surat = '';

    #[Validate('required|string|max:255')]
    public $tujuan_surat = '';

    #[Validate('required|string')]
    public $isi = '';

    #[Validate([
        'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:15360',
    ])]
    public $lampiran = [];

protected $rules = [
    'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:15360',
];

    public function mount()
{
    $this->generateNomorSurat();
}


public function SimpanSuratKeluar()
{
    $this->validate();

    $uploadedPaths = [];

    try {

        DB::transaction(function () use (&$uploadedPaths) {

            $surat = SuratKeluar::create([
                'tanggal_surat' => $this->tanggal_surat,
                'nomor_surat' => $this->nomor_surat,
                'tujuan_surat' => $this->tujuan_surat,
                'isi' => $this->isi,
                'author_id' => Auth::id(),
            ]);

            foreach ($this->lampiran as $file) {

                $namaAsli = $file->getClientOriginalName();
                $namaFile = $file->hashName();

                $path = $file->storeAs(
                    'surat-keluar',
                    $namaFile,
                    'public'
                );

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

        // Bersihkan form setelah berhasil
        $this->reset([
            'tanggal_surat',
            'tujuan_surat',
            'isi',
            'lampiran',
        ]);
        $this->generateNomorSurat();

    } catch (\Throwable $e) {

        // Hapus file yang sudah ter-upload jika proses gagal
        foreach ($uploadedPaths as $path) {
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
    }
}

public function removeLampiran($index)
{
    unset($this->lampiran[$index]);

    $this->lampiran = array_values($this->lampiran);
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

    $nomorTerakhir = SuratKeluar::whereYear('tanggal_surat', $tahun)
        ->get()
        ->map(function ($surat) {
            return (int) explode('/', $surat->nomor_surat)[0];
        })
        ->max();

    $nomorBerikutnya = ($nomorTerakhir ?? 0) + 1;

    $this->nomor_surat = sprintf(
        '%05d/DIR/PKU/%s/%d',
        $nomorBerikutnya,
        $bulanRomawi[now()->month],
        $tahun
    );
}

    public function render()
    {
        return view('livewire.surat-keluar.create');
    }
}
