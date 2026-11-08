<div class="max-w-4xl mx-auto space-y-6">

    {{-- ===== HEADER ===== --}}
    <div class="flex items-start gap-3">
        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-md shadow-emerald-200 flex-shrink-0">
            <i class="fas fa-file-pen text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                AI Revisi Surat
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Upload dokumen PDF atau Word untuk direvisi menggunakan AI.
            </p>
        </div>
    </div>

    {{-- ===== CARD UTAMA ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-upload text-emerald-500"></i>
                Upload Dokumen
            </h2>
        </div>

        <div class="p-6 space-y-5">

            {{-- Upload File --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Pilih File <span class="text-red-500">*</span>
                </label>

                <div class="relative border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50 p-6 text-center hover:border-emerald-400 hover:bg-emerald-50/30 transition cursor-pointer group">
                    <input
                        type="file"
                        wire:model="dokumen"
                        accept=".pdf,.docx"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    >
                    <div class="pointer-events-none">
                        <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i class="fas fa-cloud-upload-alt text-xl"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-700">Klik atau seret file ke sini</p>
                        <p class="text-xs text-gray-400 mt-1">Format PDF atau DOCX, maks. 10MB</p>
                    </div>
                </div>

                @error('dokumen')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fas fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror

                <div wire:loading wire:target="dokumen" class="text-xs text-blue-600 mt-2 flex items-center gap-1.5">
                    <i class="fas fa-spinner fa-spin"></i> Mengunggah file sementara...
                </div>
            </div>

            {{-- Tombol Upload --}}
            <div>
                <button
                    type="button"
                    wire:click="prosesUpload"
                    wire:loading.attr="disabled"
                    wire:target="prosesUpload"
                    class="inline-flex items-center mt-3 gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-sm shadow-emerald-200 transition disabled:opacity-50 disabled:cursor-not-allowed">

                    <span wire:loading.remove wire:target="prosesUpload" class="inline-flex items-center gap-2">
                        <i class="fas fa-upload"></i> Upload Dokumen
                    </span>

                    <span wire:loading wire:target="prosesUpload" class="inline-flex items-center gap-2">
                        <i class="fas fa-spinner fa-spin"></i> Memproses...
                    </span>
                </button>
            </div>

            {{-- Status --}}
            @if ($status)
                <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    {{ $status }}
                </div>
            @endif

            {{-- File Info --}}
            @if ($fileName)
                <div class="border border-gray-200 rounded-xl p-4 flex items-center gap-3 bg-gray-50/50">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-file-lines text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-gray-800 truncate">
                            {{ $fileName }}
                        </p>
                        <p class="text-xs text-emerald-600 flex items-center gap-1">
                            <i class="fas fa-check-circle"></i> File berhasil diunggah
                        </p>
                    </div>
                </div>
            @endif

        </div>
    </div>

       {{-- ===== HASIL PEMBACAAN DOKUMEN ===== --}}
    @if ($isiDokumen)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-file-lines text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">
                            Hasil Pembacaan Dokumen
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Teks yang berhasil diekstrak dari dokumen yang diunggah
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 text-xs bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-full font-medium">
                        <i class="fas fa-text-width"></i>
                        {{ mb_strlen($isiDokumen) }} karakter
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs bg-gray-50 text-gray-600 border border-gray-200 px-3 py-1.5 rounded-full font-medium">
                        <i class="fas fa-align-left"></i>
                        {{ str_word_count($isiDokumen) }} kata
                    </span>
                </div>
            </div>

            {{-- Area baca --}}
            <div class="p-4 sm:p-6 bg-gray-50/30">
                <div class="mx-auto max-w-3xl">
                    <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm">

                        {{-- Toolbar kertas --}}
                        <div class="flex items-center justify-between px-6 py-3 border-b border-gray-100 text-xs text-gray-500">
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-lock text-gray-400"></i>
                                Mode Baca (read-only)
                            </span>
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-file-alt text-blue-400"></i>
                                Dokumen Asli
                            </span>
                        </div>

                        {{-- Isi dokumen --}}
                        <div class="px-8 sm:px-12 py-8 sm:py-10">
                            <textarea
                                readonly
                                rows="24"
                                class="w-full bg-transparent border-0 p-0
                                       text-[16px] sm:text-[17px] leading-[2]
                                       text-gray-800 font-serif
                                       focus:outline-none focus:ring-0
                                       resize-none
                                       min-h-[600px]
                                       whitespace-pre-wrap"
                            >{{ $isiDokumen }}</textarea>
                        </div>

                        {{-- Footer kertas --}}
                        <div class="px-6 sm:px-12 py-3 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2 text-[11px] text-gray-400">
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-circle-info"></i>
                                Teks diekstrak otomatis oleh AI — mungkin ada kesalahan pembacaan.
                            </span>
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-align-left"></i>
                                {{ str_word_count($isiDokumen) }} kata • {{ mb_strlen($isiDokumen) }} karakter
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endif
    {{-- ===== INSTRUKSI REVISI ===== --}}
    @if ($isiDokumen)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <i class="fas fa-wand-magic-sparkles text-purple-500"></i>
                    Instruksi Revisi AI
                </h3>
                <p class="text-xs text-gray-500 mt-1">
                    Jelaskan bagian yang ingin diperbaiki oleh AI.
                </p>
            </div>

            <div class="p-6 space-y-4">

                <textarea
                    wire:model="instruksi"
                    rows="4"
                    placeholder="Contoh: Perbaiki tata bahasa surat agar lebih formal dan profesional..."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500/40 focus:border-purple-500 transition resize-none"
                ></textarea>

                @error('instruksi')
                    <p class="text-red-500 text-xs flex items-center gap-1">
                        <i class="fas fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror

                <button
                    type="button"
                    wire:click="revisi"
                    wire:loading.attr="disabled"
                    wire:target="revisi"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-sm shadow-emerald-200 transition disabled:opacity-50 disabled:cursor-not-allowed">

                    <span wire:loading.remove wire:target="revisi" class="inline-flex items-center gap-2">
                        <i class="fas fa-wand-magic-sparkles"></i> Revisi dengan AI
                    </span>

                    <span wire:loading wire:target="revisi" class="inline-flex items-center gap-2">
                        <i class="fas fa-spinner fa-spin"></i> Sedang memproses AI...
                    </span>
                </button>

            </div>
        </div>
    @endif

    {{-- ===== HASIL REVISI ===== --}}
    {{-- @if ($hasil)
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-200/80 overflow-hidden">

            <div class="px-6 py-4 border-b border-emerald-100 bg-emerald-50/50 flex items-center justify-between gap-3">
                <h3 class="text-sm font-semibold text-emerald-700 flex items-center gap-2">
                    <i class="fas fa-file-circle-check text-emerald-500"></i>
                    Hasil Revisi AI
                </h3>

                <span class="inline-flex items-center gap-1.5 text-xs bg-emerald-100 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full font-medium">
                    <i class="fas fa-check-circle"></i>
                    Berhasil
                </span>
            </div>

            <div class="p-6 space-y-3">

                <textarea
                    wire:model="hasil"
                    rows="15"
                    class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 font-serif leading-7 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition resize-y"
                ></textarea>

                <div class="flex justify-end">
    <button
        type="button"
        wire:click="downloadWord"
        wire:loading.attr="disabled"
        wire:target="downloadWord"
        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50">

        <span wire:loading.remove wire:target="downloadWord">
            Download Word (.docx)
        </span>

        <span wire:loading wire:target="downloadWord">
            Menyiapkan dokumen...
        </span>
    </button>
</div>

                <p class="text-xs text-gray-500 flex items-start gap-1.5">
                    <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                    Kamu bisa mengedit hasil revisi sebelum mengunduhnya.
                </p>

            </div>
        </div>
    @endif --}}
    {{-- ===== HASIL REVISI (seperti kertas A4) ===== --}}
    @if ($hasil)
        <div class="bg-white rounded-2xl shadow-sm border border-emerald-200/80 overflow-hidden">

            {{-- Card Header --}}
            <div class="px-6 py-4 border-b border-emerald-100 bg-emerald-50/50 flex items-center justify-between gap-3">
                <h3 class="text-sm font-semibold text-emerald-700 flex items-center gap-2">
                    <i class="fas fa-file-circle-check text-emerald-500"></i>
                    Hasil Revisi AI
                </h3>

                <span class="inline-flex items-center gap-1.5 text-xs bg-emerald-100 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full font-medium">
                    <i class="fas fa-check-circle"></i>
                    Berhasil
                </span>
            </div>

            {{-- Wrapper kertas --}}
            <div class="p-4 sm:p-8 bg-gray-100">

                <div class="mx-auto max-w-3xl">
                    {{-- Kertas A4 dengan rasio ~1:1.414 --}}
                    <div class="bg-white shadow-xl rounded-sm border border-gray-200/80">

                        {{-- Toolbar kecil di atas kertas --}}
                        <div class="flex items-center justify-between px-6 py-3 border-b border-gray-100 text-xs text-gray-500">
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-file-word text-blue-500"></i>
                                Draf Surat Resmi
                            </span>
                            <span class="flex items-center gap-1.5">
                                <i class="fas fa-text-width"></i>
                                {{ mb_strlen($hasil) }} karakter
                            </span>
                        </div>

                        {{-- Area kertas (editable) --}}
                        <div class="px-10 sm:px-16 py-10 sm:py-14">
                            <textarea
                                wire:model="hasil"
                                rows="30"
                                spellcheck="false"
                                class="w-full bg-transparent border-0 p-0 text-[15px] leading-8 text-gray-800 font-serif
                                       focus:outline-none focus:ring-0 resize-none
                                       min-h-[800px]"
                            ></textarea>
                        </div>

                        {{-- Footer kertas (nomor halaman / watermark) --}}
                        <div class="px-10 sm:px-16 py-4 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                            <span>Dokumen ini dihasilkan oleh AI — mohon diperiksa kembali.</span>
                            <span>Halaman 1 / 1</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer aksi di luar kertas --}}
            <div class="px-6 py-4 border-t border-emerald-100 bg-emerald-50/30 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <p class="text-xs text-gray-500 flex items-start gap-1.5">
                    <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                    Kamu bisa mengedit hasil revisi sebelum mengunduhnya.
                </p>

                <button
                    type="button"
                    wire:click="downloadWord"
                    wire:loading.attr="disabled"
                    wire:target="downloadWord"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-sm shadow-blue-200 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="downloadWord" class="inline-flex items-center gap-2">
                        <i class="fas fa-download"></i> Download Word (.docx)
                    </span>
                    <span wire:loading wire:target="downloadWord" class="inline-flex items-center gap-2">
                        <i class="fas fa-spinner fa-spin"></i> Menyiapkan dokumen...
                    </span>
                </button>
            </div>

        </div>
    @endif
</div>
