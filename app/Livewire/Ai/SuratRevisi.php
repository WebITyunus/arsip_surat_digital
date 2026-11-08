<?php

namespace App\Livewire\Ai;

use App\Ai\Agents\SuratAssistant;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class SuratRevisi extends Component
{
    use WithFileUploads;

      public $dokumen = null;
    #[Locked]
    public ?string $filePath = null;

    public $fileName = '';

    public $instruksi = '';

    public $hasil = '';

    public $loading = false;

    public $status = '';
    public $isiDokumen = '';

public function prosesUpload()
{
    $this->validate([
        'dokumen' => 'required|file|mimes:pdf,docx|max:10240',
    ], [
        'dokumen.required' => 'Silakan pilih file surat.',
        'dokumen.mimes' => 'File harus berformat PDF atau DOCX.',
        'dokumen.max' => 'Ukuran file maksimal 10 MB.',
    ]);

    if ($this->filePath) {
        Storage::disk('local')->delete($this->filePath);
    }

    $extension = strtolower(
        $this->dokumen->getClientOriginalExtension()
    );

    $this->filePath = $this->dokumen->storeAs(
        'ai-revisions',
        Str::uuid() . '.' . $extension,
        'local'
    );

    $this->fileName = $this->dokumen->getClientOriginalName();

    $this->dokumen = null;
    $this->hasil = '';

    try {
        $this->isiDokumen = $this->ekstrakDokumen($this->filePath);

        if (trim($this->isiDokumen) === '') {
            throw new \RuntimeException(
                'Dokumen tidak memiliki teks yang dapat dibaca.'
            );
        }

        $this->status = 'File berhasil diunggah dan dibaca.';
    } catch (\Throwable $e) {
        report($e);

        Storage::disk('local')->delete($this->filePath);

        $this->filePath = null;
        $this->fileName = '';
        $this->isiDokumen = '';

        $this->addError(
            'dokumen',
            'Dokumen gagal dibaca. Pastikan file tidak rusak, tidak terkunci, dan memiliki teks.'
        );
    }
}
public function updatedDokumen()
{
    if ($this->dokumen) {
        logger('Dokumen sementara berhasil diterima', [
            'name' => $this->dokumen->getClientOriginalName(),
            'size' => $this->dokumen->getSize(),
        ]);
    }
}
public function revisi()
{
    $this->validate([
        'filePath' => 'required|string',
        'isiDokumen' => 'required|string',
        'instruksi' => 'required|string|min:5|max:3000',
    ], [
        'filePath.required' => 'File surat belum diunggah.',
        'isiDokumen.required' => 'Isi dokumen tidak ditemukan.',
        'instruksi.required' => 'Instruksi revisi wajib diisi.',
        'instruksi.min' => 'Instruksi minimal 5 karakter.',
    ]);

    $this->loading = true;
    $this->hasil = '';
    $this->resetErrorBag('revisi');

    $this->status = 'Sedang memproses revisi surat...';

    try {
        $agent = new SuratAssistant();

        $prompt = "
            Kamu bertugas merevisi dokumen surat.

            ISI SURAT ASLI:
            {$this->isiDokumen}

            INSTRUKSI REVISI:
            {$this->instruksi}

            KETENTUAN:
            - Pertahankan maksud dan informasi penting surat.
            - Jangan mengarang nama, tanggal, nomor surat, atau jabatan.
            - Jangan mengubah informasi yang tidak diminta.
            - Gunakan bahasa Indonesia formal.
            - Pertahankan struktur surat yang sesuai.
            - Gunakan placeholder jika informasi belum tersedia.
            - Berikan hanya hasil surat yang sudah direvisi.
            - jelaskan apa saja yang dirubah.
        ";

        $response = $agent->prompt(
            $prompt,
            model: 'gemini-3.6-flash'
        );

        $this->hasil = (string) $response;

        $this->status = 'Revisi surat berhasil diselesaikan.';

        $this->dispatch(
            'notify',
            message: 'Surat berhasil direvisi.'
        );

    } catch (Throwable $e) {

        report($e);

        $this->status = 'Terjadi kesalahan saat memproses revisi.';

        $this->addError(
            'revisi',
            'Gagal merevisi surat. Silakan coba kembali.'
        );

    } finally {
        $this->loading = false;
    }
}
private function ekstrakDokumen(string $path): string
{
    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    return match ($extension) {
        'pdf' => $this->bacaPDF($path),
        'docx' => $this->bacaDOCX($path),
        default => throw new \RuntimeException('Format dokumen tidak didukung.'),
    };
}

private function bacaPDF(string $path): string
{
    $fullPath = Storage::disk('local')->path($path);

    $parser = new \Smalot\PdfParser\Parser();

    $pdf = $parser->parseFile($fullPath);

    return trim($pdf->getText());
}

private function bacaDOCX(string $path): string
{
    $fullPath = Storage::disk('local')->path($path);

    $phpWord = \PhpOffice\PhpWord\IOFactory::load($fullPath);

    $text = [];

    foreach ($phpWord->getSections() as $section) {
        foreach ($section->getElements() as $element) {
            $text[] = $this->ambilTeksElement($element);
        }
    }

    return trim(implode("\n", array_filter($text)));
}

private function ambilTeksElement($element): string
{
    if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
        return $element->getText();
    }

    if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
        $text = '';

        foreach ($element->getElements() as $child) {
            $text .= $this->ambilTeksElement($child);
        }

        return $text;
    }

    if ($element instanceof \PhpOffice\PhpWord\Element\TextBreak) {
        return "\n";
    }

    return '';
}

public function downloadWord()
{
    $this->validate([
        'hasil' => 'required|string',
    ]);

    $phpWord = new \PhpOffice\PhpWord\PhpWord();

    $phpWord->setDefaultFontName('Arial');
    $phpWord->setDefaultFontSize(12);

    $section = $phpWord->addSection([
        'paperSize' => 'A4',
        'marginTop' => 1440,
        'marginBottom' => 1440,
        'marginLeft' => 1701,
        'marginRight' => 1417,
    ]);

    // Membersihkan karakter kontrol
    $isiSurat = preg_replace(
        '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/',
        '',
        $this->hasil
    );

    // Memisahkan teks berdasarkan baris baru
    $baris = preg_split('/\r\n|\r|\n/', $isiSurat);

    foreach ($baris as $teks) {

        if (trim($teks) === '') {
            $section->addTextBreak(1);
            continue;
        }

        $section->addText(
            trim($teks),
            [
                'name' => 'Arial',
                'size' => 12,
            ],
            [
                'alignment' => 'both',
                'spaceAfter' => 120,
                'lineHeight' => 1.5,
                'keepNext' => false,
                'keepLines' => false,
            ]
        );
    }

    $namaDasar = Str::slug(
        pathinfo(
            $this->fileName ?: 'surat',
            PATHINFO_FILENAME
        )
    );

    $namaFile = ($namaDasar ?: 'surat') . '-hasil-revisi.docx';

    $path = storage_path('app/' . Str::uuid() . '.docx');

    $writer = \PhpOffice\PhpWord\IOFactory::createWriter(
        $phpWord,
        'Word2007'
    );

    $writer->save($path);

    return response()
        ->download($path, $namaFile)
        ->deleteFileAfterSend(true);
}


    public function render()
    {
        return view('livewire.ai.surat-revisi')
            ->layout('layouts.template');
    }
}
