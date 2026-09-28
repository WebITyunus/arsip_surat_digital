
<div>
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex items-center gap-2">
        <i class="fas fa-home text-blue-500 text-xs"></i>
        <span>/</span>
        <a href="#" class="hover:text-gray-700">Dashboard</a>
        <span>/</span>
        <a href="#" class="hover:text-gray-700">Kelola User</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">Edit User</span>
    </div>

    <!-- Page title -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-3">
                <i class="fas fa-user-edit text-blue-600"></i>
                Edit User
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Perbarui data pengguna arsip surat
            </p>
        </div>

        <a
            href="#"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm mt-4 sm:mt-0"
        >
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>


    <!-- ===== FORM CARD ===== -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">

        <div class="p-6 md:p-8">

            <form wire:submit="UpdateUser">

                <div class="space-y-6">

                    <!-- Info User -->
                    <div class="flex items-center gap-2 text-sm text-gray-400 bg-gray-50 px-4 py-2 rounded-xl border border-gray-200">

                        <i class="fas fa-id-card"></i>

                        <span>
                            ID User:
                            <span class="font-medium text-gray-700">
                                #{{ $user->id }}
                            </span>
                        </span>

                        <span class="mx-2">|</span>

                        <i class="fas fa-calendar-alt"></i>

                        <span>
                            Terdaftar:
                            <span class="font-medium text-gray-700">
                                {{ $user->created_at?->format('d M Y, H:i') }}
                            </span>
                        </span>

                    </div>


                    <!-- Row 1: Nama & Username -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Nama -->
                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Lengkap
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                wire:model="name"
                                placeholder="Masukkan nama lengkap"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('name') border-red-500 @enderror"
                            >

                            @error('name')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        <!-- Username -->
                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Username
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                wire:model="username"
                                placeholder="Masukkan username"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('username') border-red-500 @enderror"
                            >

                            @error('username')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


                    <!-- Row 2: Email -->
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat Email
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="email"
                            wire:model="email"
                            placeholder="contoh@instansi.go.id"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('email') border-red-500 @enderror"
                        >

                        @error('email')
                            <p class="text-red-500 text-xs mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

 <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Unit <span class="text-red-500">*</span>
    </label>

    <select
        wire:model="unit_id"
        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl
               focus:outline-none input-focus transition bg-white">

        <option value="">
            -- Pilih Unit --
        </option>

        @foreach ($units as $unit)
            <option value="{{ $unit->id }}">
                {{ $unit->kode_unit }} - {{ $unit->nama_unit }}
            </option>
        @endforeach

    </select>

    @error('unit_id')
        <p class="mt-1 text-xs text-red-500">
            {{ $message }}
        </p>
    @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Pokja <span class="text-red-500">*</span>
    </label>

    <select
        wire:model="pokja_id"
        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl
               focus:outline-none input-focus transition bg-white">

        <option value="">
            -- Pilih Pokja --
        </option>

        @foreach ($pokjars as $pokja)
            <option value="{{ $pokja->id }}">
                {{ $pokja->kode }} - {{ $pokja->nama }}
            </option>
        @endforeach

    </select>

    @error('pokja_id')
        <p class="mt-1 text-xs text-red-500">
            {{ $message }}
        </p>
    @enderror
</div>


                    <!-- Row 3: Password -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Password -->
                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Kata Sandi Baru
                                <span class="text-gray-400 text-xs">
                                    (kosongkan jika tidak diubah)
                                </span>
                            </label>

                            <input
                                type="password"
                                wire:model="password"
                                placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('password') border-red-500 @enderror"
                            >

                            @error('password')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        <!-- Password Confirmation -->
                        <div>

                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Konfirmasi Kata Sandi Baru
                            </label>

                            <input
                                type="password"
                                wire:model="password_confirmation"
                                placeholder="Ulangi kata sandi baru"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition @error('password_confirmation') border-red-500 @enderror"
                            >

                            @error('password_confirmation')
                                <p class="text-red-500 text-xs mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>


<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Role <span class="text-red-500">*</span>
    </label>

    <select
        wire:model="role"
        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl
               focus:outline-none focus:ring-2 focus:ring-blue-500
               @error('role') border-red-500 @enderror"
    >
        <option value="">-- Pilih Role --</option>

        @foreach ($roles as $item)
            <option value="{{ $item->name }}">
                {{ $item->name }}
            </option>
        @endforeach
    </select>

    @error('role')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100">

                        <a
                            href="{{ route('petugas-ardi') }}"
                            class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition text-center"
                        >
                            Batal
                        </a>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-md shadow-blue-200 transition flex items-center justify-center gap-2"
                        >

                            <i
                                class="fas fa-save"
                                wire:loading.remove
                                wire:target="UpdateUser"
                            ></i>

                            <i
                                class="fas fa-spinner fa-spin"
                                wire:loading
                                wire:target="UpdateUser"
                            ></i>

                            <span wire:loading.remove wire:target="UpdateUser">
                                Update User
                            </span>

                            <span wire:loading wire:target="UpdateUser">
                                Menyimpan...
                            </span>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- ===== HAPUS USER ===== -->
    <div class="mt-6 p-4 bg-red-50/50 border border-red-200 rounded-2xl">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-lg"></i>
                </div>

                <div>

                    <p class="text-sm font-medium text-red-800">
                        Hapus User Ini
                    </p>

                    <p class="text-xs text-red-600">
                        Tindakan ini tidak dapat dibatalkan.
                        Semua data terkait user akan hilang.
                    </p>

                </div>

            </div>

            <button
                type="button"
                wire:click="delete"
                wire:confirm="Yakin ingin menghapus user ini?"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-medium transition shadow-sm shadow-red-200"
            >

                <i class="fas fa-trash-alt"></i>
                Hapus User

            </button>

        </div>

    </div>

    <!-- footer spacer -->
    <div class="h-6"></div>

</div>

