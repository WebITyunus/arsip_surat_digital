<?php

namespace App\Livewire\Pokja;

use App\Models\Pokjars;
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

    #[Validate('required|string|max:5000')]
    public $isi = '';


    #[Validate([
        'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
    ])]
    public $lampiran = [];


    public function SimpanPokja()
    {
        $this->validate();

        $uploadedPaths = [];

        try {

            DB::transaction(function () use (&$uploadedPaths) {

                $surat = Pokjars::create([
                    'tanggal_surat' => $this->tanggal_surat,
                    'isi'           => $this->isi,
                    'pokja_id'      => Auth::user()->pokja_id,
                    'author_id'     => Auth::id(),
                ]);

                foreach ($this->lampiran as $file) {

                    $namaAsli = $file->getClientOriginalName();
                    $namaFile = $file->hashName();

                    $path = $file->storeAs(
                        'surat/pokjars',
                        $namaFile,
                        'public'
                    );

                    $uploadedPaths[] = $path;

                    $surat->files()->create([
                        'nama_file' => $namaFile,
                        'nama_asli' => $namaAsli,
                        'path'      => $path,
                    ]);
                }
            });

            $this->reset();

            $this->dispatch(
                'notify',
                type: 'success',
                title: 'Berhasil',
                message: 'Surat Pokja berhasil disimpan.'
            );

        } catch (\Throwable $e) {

            foreach ($uploadedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            report($e);

            $this->dispatch(
                'notify',
                type: 'error',
                title: 'Gagal',
                message: 'Surat Pokja gagal disimpan.'
            );
        }
    }


    public function removeLampiran($index)
    {
        unset($this->lampiran[$index]);

        $this->lampiran = array_values($this->lampiran);
    }

    public function render()
    {
        return view('livewire.pokja.create');
    }
}
