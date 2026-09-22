<div>


        <!-- ===== PAGE CONTENT ===== -->
        <main class="flex-1 p-4 md:p-8 overflow-y-auto">

            <!-- Breadcrumb -->
            <div class="text-sm text-gray-500 mb-6 flex items-center gap-2">
                <i class="fas fa-home text-blue-500 text-xs"></i>
                <span>/</span>
                <a href="#" class="hover:text-gray-700">Dashboard</a>
                <span>/</span>
                <a href="#" class="hover:text-gray-700">Surat Masuk</a>
                <span>/</span>
                <span class="text-gray-700 font-medium">Tambah Surat</span>
            </div>

            <!-- Page title -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <i class="fas fa-plus-circle text-blue-600"></i> Tambah Surat Masuk
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Isi data surat dengan lengkap dan benar.</p>
                </div>

            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-6 md:p-8">
                <!-- ===== SESSION FLASH MESSAGES ===== -->
@if (session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 10000)"
        x-show="show"
        x-transition
        class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 flex items-center gap-3"
    >
        <i class="fas fa-check-circle text-lg"></i>
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 10000)"
        x-show="show"
        x-transition
        class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 flex items-center gap-3"
    >
        <i class="fas fa-exclamation-circle text-lg"></i>
        {{ session('error') }}
    </div>
@endif

                <form wire:submit.prevent="UpdatePks" method="POST" enctype="multipart/form-data">

                    <div class="space-y-6">

<!-- Row 1: Nomor Surat & Tanggal -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Nomor Surat <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            wire:model="nomor_surat"
            readonly
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('surat.nomor_surat') border-red-500 @enderror"
        />

        @error('nomor_surat')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>



    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Tanggal Surat <span class="text-red-500">*</span>
        </label>

        <input
            type="date"
            wire:model="tanggal_surat"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('surat.tanggal_surat') border-red-500 @enderror"
        />

        @error('tanggal_surat')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

     <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Tanggal Mulai <span class="text-red-500">*</span>
        </label>

        <input
            type="date"
            wire:model="tanggal_mulai"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('surat.tanggal_mulai') border-red-500 @enderror"
        />

        @error('tanggal_mulai')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

     <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Tanggal Berakhir <span class="text-red-500">*</span>
        </label>

        <input
            type="date"
            wire:model="tanggal_berakhir"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('surat.tanggal_berakhir') border-red-500 @enderror"
        />

        @error('tanggal_berakhir')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>


<!-- Row 2: Pengirim & Penerima -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Tujuan Surat <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            wire:model="tujuan_surat"
            placeholder="Nama instansi atau perorangan"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('surat.tujuan_surat') border-red-500 @enderror"
        />

        @error('tujuan_surat')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

     <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Pembuat <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            wire:model="author_id"
            readonly
            placeholder="Nama instansi atau perorangan"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('surat.author_id') border-red-500 @enderror"
        />

        @error('author_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>


</div>


<!-- Perihal -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Perihal <span class="text-red-500">*</span>
    </label>

    <input
        type="text"
        wire:model="isi"
        placeholder="Judul / perihal surat"
        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('surat.isi') border-red-500 @enderror"
    />

    @error('isi')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

                       <!-- Lampiran Lama -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Lampiran File
    </label>

    @forelse ($surat->files as $file)

        <div
            wire:key="file-{{ $file->id }}"
            class="mb-3 px-4 py-3 bg-gray-50 rounded-xl border border-gray-200 flex items-center gap-4"
        >

            {{-- Icon --}}
            <div class="w-10 h-10 flex items-center justify-center bg-red-50 rounded-lg text-red-500">
                <i class="fas fa-file-pdf text-xl"></i>
            </div>

            {{-- Informasi file --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800 truncate">
                    {{ $file->nama_asli ?? $file->nama_file }}
                </p>

                <p class="text-xs text-gray-400">
                    Diupload: {{ $file->created_at?->format('d M Y') }}
                </p>
            </div>

            {{-- Lihat --}}
            <a
                href="{{ asset('storage/' . $file->path) }}"
                target="_blank"
                class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 text-sm font-medium"
            >
                <i class="fas fa-eye"></i>
                Lihat
            </a>

            {{-- Hapus --}}
            <button
                type="button"
                wire:click="hapusFile({{ $file->id }})"
                wire:loading.attr="disabled"
                wire:target="hapusFile({{ $file->id }})"
                onclick="return confirm('Yakin ingin menghapus file ini?')"
                class="inline-flex items-center gap-1.5 text-red-500 hover:text-red-700 text-sm font-medium transition"
            >
                <span wire:loading.remove wire:target="hapusFile({{ $file->id }})">
                    <i class="fas fa-trash"></i>
                    Hapus
                </span>

                <span wire:loading wire:target="hapusFile({{ $file->id }})">
                    <i class="fas fa-spinner fa-spin"></i>
                    Menghapus...
                </span>
            </button>

        </div>

    @empty

        <div class="px-4 py-3 bg-gray-50 rounded-xl border border-gray-200 text-sm text-gray-400">
            <i class="fas fa-info-circle mr-1"></i>
            Belum ada lampiran.
        </div>

    @endforelse


    {{-- Upload file baru --}}
    {{-- Row 5: Upload File --}}
<div x-data="{ dragging: false }" class="w-full">

    <label class="block text-sm font-medium text-gray-700 mb-1">
        Lampiran File
    </label>

    <div
        @dragover.prevent="dragging = true"
        @dragleave.prevent="dragging = false"
        @drop.prevent="
            dragging = false;
            $refs.fileInput.files = $event.dataTransfer.files;
            $refs.fileInput.dispatchEvent(
                new Event('change', { bubbles: true })
            );
        "
        @click="$refs.fileInput.click()"
        :class="dragging
            ? 'border-indigo-500 bg-indigo-50'
            : 'border-gray-300'"
        class="border-2 border-dashed rounded-xl p-8 text-center cursor-pointer transition"
    >

        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>

        <p class="text-sm text-gray-500 mt-2">
            Klik atau seret file ke sini
        </p>

        <p class="text-xs text-gray-400 mt-1">
            PDF, JPG, PNG — maksimal 5MB per file
        </p>

        <input
            x-ref="fileInput"
            type="file"
            wire:model="lampiran"
            multiple
            accept=".pdf,.jpg,.jpeg,.png"
            class="hidden"
        />

    </div>


    {{-- Loading --}}
    <div
        wire:loading
        wire:target="lampiran"
        class="mt-2 text-sm text-gray-500"
    >
        <i class="fas fa-spinner fa-spin"></i>
        Mengupload file...
    </div>


    {{-- Error --}}
    @error('lampiran')
        <p class="text-sm text-red-500 mt-2">
            {{ $message }}
        </p>
    @enderror

    @error('lampiran.*')
        <p class="text-sm text-red-500 mt-2">
            {{ $message }}
        </p>
    @enderror


    {{-- File baru yang dipilih --}}
    @if(count($lampiran) > 0)

        <div class="mt-4 space-y-2">

            @foreach($lampiran as $index => $file)

                <div
                    wire:key="lampiran-{{ $index }}"
                    class="flex items-center justify-between
                           p-3 bg-gray-50 border border-gray-200
                           rounded-xl"
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="w-10 h-10 bg-indigo-100
                                   rounded-lg flex items-center justify-center"
                        >
                            <i class="fas fa-file text-indigo-500"></i>
                        </div>

                        <div>

                            <p class="text-sm font-medium text-gray-700">
                                {{ $file->getClientOriginalName() }}
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ number_format($file->getSize() / 1024, 1) }} KB
                            </p>

                        </div>

                    </div>

                    <button
                        type="button"
                        wire:click="removeLampiran({{ $index }})"
                        class="text-red-500 hover:text-red-700"
                    >
                        <i class="fas fa-trash"></i>
                    </button>

                </div>

            @endforeach

        </div>

    @endif

</div>



                        <!-- Tombol Aksi -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('surat-pks') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition text-center">
                                Kembali
                            </a>
                            <button
        type="submit"
        wire:loading.attr="disabled"
        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-md shadow-blue-200 transition flex items-center justify-center gap-2"
    >

        {{-- Tampilan normal --}}
        <span wire:loading.remove wire:target="UpdatePks">
            <i class="fas fa-save"></i>
            Simpan Surat
        </span>

        {{-- Tampilan loading --}}
        <span wire:loading wire:target="UpdatePks">
            <i class="fas fa-spinner fa-spin"></i>
            Menyimpan...
        </span>

    </button>
                        </div>

                    </div>
                </form>
            </div>

            <!-- footer spacer -->
            <div class="h-4"></div>

        </main>
    </div>
</div>

</div>
