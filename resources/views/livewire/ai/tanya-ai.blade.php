<div class="flex h-[calc(100vh-100px)] bg-white rounded-xl border overflow-hidden">

    {{-- SIDEBAR RIWAYAT --}}
    <aside class="w-72 shrink-0 border-r bg-gray-50 flex flex-col">

        {{-- Header Sidebar --}}
        <div class="p-4 border-b">
            <h2 class="font-bold text-lg mb-4">Tanya AI</h2>

            <button
                wire:click="newChat"
                class="w-full flex items-center justify-center gap-2
                       bg-blue-600 text-white rounded-lg px-4 py-3
                       hover:bg-blue-700 transition"
            >
                <span>+</span>
                Chat Baru
            </button>
        </div>

        {{-- Daftar Riwayat --}}
        <div class="flex-1 overflow-y-auto p-3">

            <p class="text-xs font-semibold text-gray-400 uppercase mb-3">
                Riwayat Percakapan
            </p>

            @forelse ($conversations as $conversation)

                @php
                    $firstMessage = $conversation->messages
                        ->firstWhere('role', 'user');

                    $title = $firstMessage
                        ? \Illuminate\Support\Str::limit(
                            $firstMessage->content,
                            35
                        )
                        : 'Percakapan baru';
                @endphp

                <div
                    wire:key="conversation-{{ $conversation->getKey() }}"
                    class="group flex items-center gap-1 mb-1 rounded-lg
                    {{ $conversationId === (string) $conversation->getKey()
                        ? 'bg-blue-100'
                        : 'hover:bg-gray-200' }}"
                >

                    <button
                        wire:click="openConversation('{{ $conversation->getKey() }}')"
                        class="flex-1 min-w-0 text-left px-3 py-3 text-sm"
                    >
                        <span class="block truncate font-medium text-gray-700">
                            {{ $title }}
                        </span>

                        <span class="text-xs text-gray-400">
                            {{ $conversation->updated_at->diffForHumans() }}
                        </span>
                    </button>

<button
    wire:click="deleteConversation('{{ $conversation->getKey() }}')"
    wire:confirm="Yakin ingin menghapus percakapan ini?"
    class="flex items-center gap-1.5 px-2 py-2 m-3 font-medium text-xs text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg shadow-sm transition-colors duration-150 ease-in-out"
    title="Hapus percakapan"
>
    <!-- Heroicons: Trash (Outline) -->
    <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
    </svg>
    {{-- <span>Hapus</span> --}}
</button>


                </div>

            @empty

                <div class="text-center text-sm text-gray-400 py-8">
                    Belum ada riwayat percakapan.
                </div>

            @endforelse

        </div>

        {{-- Footer Sidebar --}}
        <div class="p-3 border-t text-xs text-gray-400">
            Riwayat tersimpan di akun Anda.
        </div>

    </aside>


    {{-- AREA CHAT --}}
    <main class="flex-1 flex flex-col min-w-0">

        {{-- Header Chat --}}
        <div class="px-6 py-4 border-b">
            <h2 class="font-semibold text-gray-800">
                {{ $conversationId ? 'Percakapan Tanya AI' : 'Chat Baru' }}
            </h2>
            <p class="text-xs text-gray-400">
                Asisten AI administrasi rumah sakit
            </p>
        </div>


        {{-- Pesan --}}
        <div
            class="flex-1 overflow-y-auto p-6 space-y-6"
            id="chat-messages"
        >

            @forelse ($messages as $message)

                @if ($message['role'] === 'user')

                    <div class="flex justify-end">
                        <div class="max-w-[80%] bg-blue-600 text-white
                                    rounded-2xl px-5 py-3">
                            <div class="whitespace-pre-wrap">
                                {{ $message['content'] }}
                            </div>
                        </div>
                    </div>

                @else

                    <div class="flex justify-start gap-3">

                        <div class="w-9 h-9 rounded-full bg-blue-100
                                    flex items-center justify-center shrink-0">
                            🤖
                        </div>

                        <div class="max-w-[90%] bg-gray-100 text-gray-800
                                    rounded-2xl px-5 py-4">

                            <p class="font-semibold text-sm mb-2">
                                Tanya AI
                            </p>

                            <div class="text-sm leading-7 text-gray-800
    [&_h1]:text-xl [&_h1]:font-bold [&_h1]:mb-3
    [&_h2]:text-lg [&_h2]:font-bold [&_h2]:mt-5 [&_h2]:mb-2
    [&_h3]:text-base [&_h3]:font-bold [&_h3]:mt-4 [&_h3]:mb-2
    [&_p]:mb-3
    [&_ul]:list-disc [&_ul]:pl-6 [&_ul]:mb-3
    [&_ol]:list-decimal [&_ol]:pl-6 [&_ol]:mb-3
    [&_li]:mb-1
    [&_strong]:font-bold
    [&_table]:w-full [&_table]:border-collapse
    [&_th]:border [&_th]:p-2 [&_th]:bg-gray-200
    [&_td]:border [&_td]:p-2
    [&_pre]:bg-gray-200 [&_pre]:p-3 [&_pre]:rounded-lg [&_pre]:overflow-x-auto
    [&_code]:text-sm">

    {!! \Illuminate\Support\Str::markdown($message['content'], [
        'html_input' => 'strip',
        'allow_unsafe_links' => false,
    ]) !!}

</div>

{{-- Tombol Export --}}
<div class="flex items-center gap-2 mt-4 pt-3 border-t border-gray-200">

    <button
        type="button"
        wire:click="downloadWord({{ $loop->index }})"
        wire:loading.attr="disabled"
        class="flex items-center gap-2 px-3 py-2 text-xs font-medium
               text-blue-700 bg-blue-50 hover:bg-blue-100
               rounded-lg transition disabled:opacity-50"
    >
        📄 Download Word
    </button>

    <button
        type="button"
        wire:click="downloadPdf({{ $loop->index }})"
        wire:loading.attr="disabled"
        class="flex items-center gap-2 px-3 py-2 text-xs font-medium
               text-red-700 bg-red-50 hover:bg-red-100
               rounded-lg transition disabled:opacity-50"
    >
        📕 Download PDF
    </button>

</div>

                        </div>

                    </div>

                @endif

            @empty

                <div class="h-full flex flex-col items-center
                            justify-center text-center">

                    <div class="text-5xl mb-4">🤖</div>

                    <h2 class="text-2xl font-semibold text-gray-800">
                        Ada yang bisa saya bantu?
                    </h2>

                    <p class="text-gray-500 mt-2">
                        Tanyakan sesuatu, buat surat, atau minta bantuan
                        untuk merevisi dokumen.
                    </p>

                </div>

            @endforelse

            <div wire:loading wire:target="sendMessage"
                 class="text-sm text-gray-400">
                Tanya AI sedang berpikir...
            </div>

        </div>


       {{-- Input Chat --}}
{{-- Input Chat --}}
        <div class="p-4 border-t border-gray-100 bg-white">

            <form wire:submit="sendMessage" class="max-w-4xl mx-auto">

                {{-- Preview Lampiran --}}
                @if ($dokumen)
                    <div class="mb-3 flex items-center justify-between p-3 m-3
                                bg-blue-50/80 border border-blue-200/80 rounded-2xl shadow-xs transition-all">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0 shadow-2xs">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-800 truncate">
                                    {{ $dokumen->getClientOriginalName() }}
                                </p>
                                <p class="text-[11px] text-gray-500 mt-0.5">
                                    {{ number_format($dokumen->getSize() / 1024, 1) }} KB • Siap diunggah
                                </p>
                            </div>
                        </div>

                        <button
                            type="button"
                            wire:click="removeFile"
                            class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-white rounded-xl transition-colors shadow-2xs"
                            title="Hapus file"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                {{-- Loading Upload --}}
                <div wire:loading wire:target="dokumen"
                     class="text-xs text-blue-600 mb-2 font-medium">
                    Sedang mengunggah dokumen...
                </div>

                <div class="flex items-center gap-2.5 bg-gray-50 border border-gray-200 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-100 rounded-2xl p-2 transition-all">

                    {{-- Tombol Lampiran (DIBUAT UKURAN PRESISI & PROPORSIONAL) --}}
                    <label
                        class="cursor-pointer w-11 h-11 shrink-0 rounded-xl text-gray-600 hover:text-blue-600 hover:bg-blue-50 flex items-center justify-center bg-white border border-gray-200 shadow-2xs transition-all active:scale-95"
                        title="Lampirkan PDF atau DOCX"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                        </svg>

                        <input
                            type="file"
                            wire:model="dokumen"
                            accept=".pdf,.docx"
                            class="hidden"
                            @disabled($loading)
                        >
                    </label>

                    {{-- Input Pesan --}}
                    <textarea
                        wire:model="pesan"
                        rows="1"
                        placeholder="Ketik pesan atau instruksi surat..."
                        class="flex-1 rounded-md resize-none bg-transparent border-0 focus:ring-0 text-sm py-2.5 px-2 text-gray-800 placeholder-gray-400 max-h-32"
                        @disabled($loading)
                    ></textarea>

                    {{-- Tombol Kirim --}}
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="sendMessage"
                        class="bg-blue-600 text-white px-5 py-2.5 text-xs font-semibold
                               rounded-xl hover:bg-blue-700 active:scale-95
                               transition-all disabled:opacity-50 shadow-sm shadow-blue-500/20 shrink-0 h-11"
                    >
                        Kirim
                    </button>

                </div>

                @error('pesan')
                    <p class="text-rose-500 text-xs mt-1.5 ml-1">{{ $message }}</p>
                @enderror

                @error('dokumen')
                    <p class="text-rose-500 text-xs mt-1.5 ml-1">{{ $message }}</p>
                @enderror

                @error('export')
                    <p class="text-rose-500 text-xs mt-1.5 ml-1">{{ $message }}</p>
                @enderror

                <div class="flex items-center justify-between mt-2 px-1">
                    <p class="text-[11px] text-gray-400">
                        Format PDF/DOCX, maksimal 10 MB.
                    </p>
                    <p class="text-[11px] text-gray-400">
                        Tekan Kirim untuk memproses
                    </p>
                </div>

            </form>

        </div>

        @error('pesan')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

        @error('dokumen')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror

        @error('export')
    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
@enderror

        <p class="text-xs text-gray-400 mt-2">
            Format PDF/DOCX, maksimal 10 MB.
        </p>

    </form>

</div>

    </main>

</div>
