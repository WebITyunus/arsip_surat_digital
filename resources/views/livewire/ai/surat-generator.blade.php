<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- ===== HEADER ===== --}}
    <div class="flex items-start gap-3">
        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-200 flex-shrink-0">
            <i class="fas fa-wand-magic-sparkles text-lg"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                AI Generator Surat
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Buat draf surat resmi rumah sakit menggunakan AI.
            </p>
        </div>
    </div>

    {{-- ===== FORM GENERATE ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="fas fa-pen-to-square text-blue-500"></i>
                Formulir Generate
            </h2>
        </div>

        <div class="p-6 space-y-5">

            {{-- Jenis Surat --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Jenis Surat <span class="text-red-500">*</span>
                </label>

                <select
                    wire:model="jenisSurat"
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition"
                >
                    <option value="Surat Undangan">Surat Undangan</option>
                    <option value="Surat Tugas">Surat Tugas</option>
                    <option value="Surat Pemberitahuan">Surat Pemberitahuan</option>
                    <option value="Surat Permohonan">Surat Permohonan</option>
                    <option value="Surat Keterangan">Surat Keterangan</option>
                    <option value="Nota Dinas">Nota Dinas</option>
                </select>

                @error('jenisSurat')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fas fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Instruksi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Instruksi / Informasi Surat <span class="text-red-500">*</span>
                </label>

                <textarea
                    wire:model="instruksi"
                    rows="5"
                    placeholder="Contoh: Buatkan surat undangan rapat untuk seluruh kepala unit rumah sakit. Rapat membahas evaluasi pelayanan dan dilaksanakan di ruang rapat utama."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition resize-none"
                ></textarea>

                @error('instruksi')
                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                        <i class="fas fa-circle-exclamation"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Error Generate --}}
            @error('generate')
                <div class="bg-red-50 border border-red-200 text-red-600 p-3 rounded-xl text-sm flex items-start gap-2">
                    <i class="fas fa-circle-exclamation mt-0.5"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror

            {{-- Tombol Generate --}}
            <div class="pt-1">
                <button
                    wire:click="generate"
                    wire:loading.attr="disabled"
                    wire:target="generate"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl shadow-sm shadow-blue-200 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    {{-- State normal --}}
                    <span wire:loading.remove wire:target="generate" class="inline-flex items-center gap-2">
                        <i class="fas fa-wand-magic-sparkles"></i>
                        Generate Surat
                    </span>

                    {{-- State loading --}}
                    <span wire:loading wire:target="generate" class="inline-flex items-center gap-2">
                        <i class="fas fa-spinner fa-spin"></i>
                        Sedang membuat surat...
                    </span>
                </button>
            </div>

        </div>
    </div>

    {{-- ===== HASIL AI ===== --}}
    @if ($hasil)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">

            {{-- Card Header --}}
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between gap-3">
                <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                    <i class="fas fa-file-lines text-emerald-500"></i>
                    Hasil Draf Surat
                </h2>

                <span class="inline-flex items-center gap-1.5 text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full font-medium">
                    <i class="fas fa-check-circle"></i>
                    Berhasil dibuat
                </span>
            </div>

            <div class="p-6 space-y-3">

                <textarea
                    wire:model="hasil"
                    rows="18"
                    class="w-full px-4 py-4 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 font-serif leading-7 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition resize-y"
                ></textarea>

                <p class="text-xs text-gray-500 flex items-start gap-1.5">
                    <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                    Draf dapat diedit secara manual sebelum disimpan atau digunakan sebagai dokumen resmi.
                </p>

            </div>
        </div>
    @endif

</div>
