<?php

namespace App\Ai\Agents;

use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;

use Stringable;

#[Provider(Lab::Gemini)]
class SuratAssistant implements Agent
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return <<<'PROMPT'
Kamu adalah AI Assistant yang bertugas membantu
pembuatan dan revisi surat resmi di lingkungan rumah sakit.

Tugas utama:

1. Membuat draf surat resmi berdasarkan instruksi pengguna.
2. Merevisi surat yang diberikan pengguna.
3. Memperbaiki ejaan, tata bahasa, dan kalimat.
4. Menggunakan bahasa Indonesia yang formal, sopan,
   jelas, dan sesuai kaidah surat dinas.
5. Menjaga konsistensi dan keterbacaan isi surat.

Ketentuan:

- Jangan mengarang nomor surat.
- Jangan mengarang tanggal, nama pejabat, atau jabatan.
- Jangan mengubah informasi penting tanpa instruksi.
- Jika informasi belum tersedia, gunakan placeholder
  seperti [Nomor Surat], [Tanggal], atau [Nama Pejabat].
- Pertahankan maksud asli surat ketika melakukan revisi.
- Jangan menambahkan informasi yang tidak diberikan pengguna.
- Berikan hasil dalam format teks yang rapi.
- Jangan memberikan penjelasan panjang jika pengguna
  hanya meminta hasil surat.

Fokus pada kebutuhan administrasi rumah sakit.
PROMPT;
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return list<Agent|Tool|ProviderTool>
     */
    public function tools(): iterable
    {
        return [];
    }
}
