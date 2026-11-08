<?php

namespace App\Livewire\Ai;

use App\Ai\Agents\SuratAssistant;
use Livewire\Component;
use Throwable;

class SuratGenerator extends Component
{
    public $jenisSurat = 'Surat Undangan';

    public $instruksi = '';

    public $hasil = '';

    public $loading = false;

    protected function rules()
    {
        return [
            'jenisSurat' => 'required|string|max:100',
            'instruksi' => 'required|string|min:10|max:5000',
        ];
    }

    protected function messages()
    {
        return [
            'jenisSurat.required' => 'Silakan pilih jenis surat.',
            'instruksi.required' => 'Instruksi surat wajib diisi.',
            'instruksi.min' => 'Instruksi minimal 10 karakter.',
            'instruksi.max' => 'Instruksi maksimal 5000 karakter.',
        ];
    }


public function generate()
{
    $this->validate();

    $this->loading = true;

    try {
        $agent = new SuratAssistant();

        $prompt = "
            Buatkan draf {$this->jenisSurat}
            berdasarkan instruksi berikut:

            {$this->instruksi}

            KETENTUAN:
            - Gunakan bahasa Indonesia formal dan baku.
            - Gunakan format dokumen resmi rumah sakit.
            - Jangan mengarang nomor surat.
            - Jangan mengarang nama pejabat atau tanggal.
            - Gunakan placeholder jika informasi belum tersedia.
            - Pertahankan seluruh informasi penting dari pengguna.
            - Susun judul, paragraf, penomoran, dan tanda tangan dengan rapi.

            ATURAN OUTPUT:
            - Gunakan teks biasa (plain text).
            - Jangan gunakan Markdown.
            - Jangan gunakan tanda #, **, *, atau --- sebagai format.
            - Jangan gunakan tag HTML.
            - Jangan memberikan pengantar seperti 'Berikut adalah draf'.
            - Jangan memberikan penjelasan perubahan.
            - Jangan memberikan kesimpulan atau komentar di luar dokumen.

            FORMAT OUTPUT WAJIB:

            [[[MULAI_DOKUMEN]]]

            Isi lengkap dokumen di sini.

            [[[AKHIR_DOKUMEN]]]

            Pastikan output dimulai dengan [[[MULAI_DOKUMEN]]]
            dan diakhiri dengan [[[AKHIR_DOKUMEN]]].
        ";

        $response = $agent->prompt(
            $prompt,
            model: 'gemini-3.6-flash'
        );

        $teks = (string) $response;

        // Ambil hanya bagian dokumen
        if (preg_match(
            '/\[\[\[MULAI_DOKUMEN\]\]\](.*?)\[\[\[AKHIR_DOKUMEN\]\]\]/s',
            $teks,
            $matches
        )) {
            $teks = $matches[1];
        }

        $this->hasil = $this->bersihkanMarkdown($teks);

        $this->dispatch(
            'notify',
            message: 'Draf surat berhasil dibuat.'
        );

    } catch (Throwable $e) {

        report($e);

        $this->addError(
            'generate',
            'Gagal membuat surat. Silakan coba kembali beberapa saat lagi.'
        );

    } finally {
        $this->loading = false;
    }
}

private function bersihkanMarkdown(string $teks): string
{
    // Normalisasi baris baru
    $teks = str_replace(["\r\n", "\r"], "\n", $teks);

    // Ubah HTML break menjadi baris baru
    $teks = preg_replace('/<br\s*\/?>/i', "\n", $teks);

    // Hapus tag HTML
    $teks = strip_tags($teks);

    // Hapus garis pemisah Markdown
    $teks = preg_replace(
        '/^\s*(?:-{3,}|\*{3,}|_{3,})\s*$/m',
        '',
        $teks
    );

    // Hapus heading Markdown
    $teks = preg_replace(
        '/^\s{0,3}#{1,6}\s*/m',
        '',
        $teks
    );

    // Ubah bullet Markdown menjadi bullet biasa
    $teks = preg_replace(
        '/^\s*[-*+]\s+/m',
        '• ',
        $teks
    );

    // Hapus simbol bold dan italic
    $teks = str_replace(
        ['**', '__'],
        '',
        $teks
    );

    // Hapus simbol asterisk tersisa
    $teks = str_replace('*', '', $teks);

    // Rapikan baris kosong
    $teks = preg_replace("/\n{3,}/", "\n\n", $teks);

    return trim($teks);
}

    public function render()
    {
        return view('livewire.ai.surat-generator')
            ->layout('layouts.template');
    }
}
