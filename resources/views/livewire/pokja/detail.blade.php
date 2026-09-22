<div>

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
            <a href="#" class="hover:text-blue-600 transition">
                <i class="fas fa-home text-blue-500 text-xs"></i>
            </a>
            <span class="text-gray-300">/</span>
            <a href="/dashboard" class="hover:text-blue-600 transition">Dashboard</a>
            <span class="text-gray-300">/</span>
            <a href="/pokja-masuk" class="hover:text-blue-600 transition">file Pokja</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-700 font-medium">Detail</span>
        </nav>

        <!-- Page title & actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 text-blue-600">
                        <i class="fas fa-file-alt text-lg"></i>
                    </span>
                    Detail Data Pokja
                </h1>
                <p class="text-gray-500 text-sm mt-1">Lihat informasi lengkap pokja masuk</p>
            </div>
            <div class="flex flex-wrap gap-2">
                {{-- <a href="{{ route('edit-pokja',$pokja) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition shadow-sm">
                    <i class="fas fa-edit text-blue-500"></i> Edit
                </a> --}}

                <a href="/index-pokja" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium shadow-md shadow-blue-200 transition">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>

            </div>
        </div>

        <!-- ===== DETAIL CARD ===== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/70 overflow-hidden">

            <!-- Header Card -->
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-200/70 flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-full border border-blue-200">
                         {{ $pokja->nomor_surat }}
                    </span>

                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-50 text-purple-700 text-xs font-semibold rounded-full border border-purple-200">
                        <i class="fas fa-tag text-purple-500"></i> Surat Pokja
                    </span>
                </div>
                <span class="text-xs text-gray-400 flex items-center gap-1">
                    <i class="far fa-calendar-alt"></i> Dibuat: {{ $pokja->author->name ?? 'admin' }} pada {{ $pokja->created_at }}
                </span>
            </div>

            <!-- Body -->
            <div class="p-6 md:p-8 space-y-8">

                <!-- Grid informasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                    <div>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-1.5 mb-1">
                            <i class="fas fa-calendar-day text-gray-300"></i> Tanggal Surat
                        </span>
                        <div class="px-4 py-2.5 bg-gray-50/80 rounded-xl border border-gray-200/70 text-gray-800">
                            {{ $pokja->tanggal_surat }}
                        </div>
                    </div>


                    <div>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-1.5 mb-1">
                            <i class="fas fa-heading text-gray-300"></i> Perihal
                        </span>
                        <div class="px-4 py-2.5 bg-gray-50/80 rounded-xl border border-gray-200/70 text-gray-800 font-semibold text-base">
                           {{ $pokja->isi }}
                        </div>
                    </div>


                       <!-- Lampiran -->
                  @if ($pokja->files->isNotEmpty())
    <div>
        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-1.5 mb-2">
            <i class="fas fa-paperclip text-gray-300"></i>
            Lampiran
        </span>

        <div class="space-y-4">
            @foreach ($pokja->files as $file)

                @php
                   $extension = strtolower(pathinfo($file->nama_asli, PATHINFO_EXTENSION));
                    $url = asset('storage/' . $file->path);
                @endphp


                <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">

                    {{-- Header file --}}
                    <div class="px-4 py-3 flex items-center justify-between border-b bg-white">

                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-500 rounded-lg">
                                <i class="fas fa-file-pdf text-xl"></i>
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">
                                    {{ $file->nama_asli ?? $file->nama_file }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    {{ strtoupper($extension) }}
                                    • {{ $file->created_at?->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        <a
                            href="{{ $url }}"
                            target="_blank"
                            class="inline-flex items-center gap-2 px-3 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-lg"
                        >
                            <i class="fas fa-external-link-alt"></i>
                            Buka
                        </a>

                    </div>

                    {{-- Preview PDF --}}
                    @if ($extension === 'pdf')

                        <iframe
                            src="{{ $url }}"
                            class="w-full h-[700px]"
                            frameborder="0"
                        ></iframe>

                    @elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))

                        <div class="p-4 flex justify-center bg-gray-100">
                            <img
                                src="{{ $url }}"
                                alt="{{ $file->nama_asli }}"
                                class="max-w-full max-h-[700px] object-contain rounded-lg shadow-sm"
                            >
                        </div>

                    @else

                        <div class="p-8 text-center text-gray-500">
                            <i class="fas fa-file text-4xl mb-3"></i>

                            <p class="text-sm">
                                File ini tidak dapat dipreview.
                            </p>

                            <a
                                href="{{ $url }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 mt-3 text-blue-600 hover:text-blue-800"
                            >
                                <i class="fas fa-download"></i>
                                Download File
                            </a>
                        </div>

                    @endif

                </div>

            @endforeach
        </div>
    </div>
@endif


                </div>



            </div>
        </div>

        <!-- footer spacer -->
        <div class="h-6"></div>

    </main>
</div>
</div>
</div>
