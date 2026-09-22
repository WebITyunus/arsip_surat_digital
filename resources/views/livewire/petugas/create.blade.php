<div>
                <!-- Breadcrumb -->
                <div class="text-sm text-gray-500 mb-6 flex items-center gap-2">
                    <i class="fas fa-home text-blue-500 text-xs"></i>
                    <span>/</span>
                    <a href="#" class="hover:text-gray-700">Dashboard</a>
                    <span>/</span>
                    <a href="#" class="hover:text-gray-700">Kelola User</a>
                    <span>/</span>
                    <span class="text-gray-700 font-medium">Tambah User</span>
                </div>

                <!-- Page title -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-3">
                            <i class="fas fa-user-plus text-blue-600"></i> Tambah User
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">Tambahkan pengguna baru untuk mengelola arsip surat</p>
                    </div>
                    <a href="#" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm mt-4 sm:mt-0">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>


                <!-- ===== FORM CARD ===== -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">
                    <div class="p-6 md:p-8">
<form wire:submit="SimpanUser">
                            <div class="space-y-6">

                                <!-- Row 1: Nama Lengkap & Email -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                     <input
    type="text"
    wire:model="name"
    placeholder="Masukkan nama lengkap"
    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl"
/>

@error('name')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
                                    </div>
                                    <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Username <span class="text-red-500">*</span>
    </label>

    <input
        type="text"
        wire:model="username"
        placeholder="Masukkan username"
        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl"
    />

    @error('username')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Alamat Email <span class="text-red-500">*</span>
                                        </label>
                                   <input
    type="email"
    wire:model="email"
    placeholder="contoh@instansi.go.id"
    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl"
/>

@error('email')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
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


                                </div>

                                <!-- Row 2: Password & Konfirmasi -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Kata Sandi <span class="text-red-500">*</span>
                                        </label>
                                    <input
    type="password"
    wire:model="password"
    placeholder="Minimal 8 karakter"
    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl"
/>

@error('password')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
@enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                                        </label>
                                    <input
    type="password"
    wire:model="password_confirmation"
    placeholder="Ulangi kata sandi"
    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl"
/>
                                    </div>
                                </div>

                                <!-- Row 3: Role & Status -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Peran (Role) <span class="text-red-500">*</span>
                                        </label>
                                        <select   wire:model="role" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition bg-white">
                                            <option value="">Pilih Role</option>

        @foreach ($roles as $item)
            <option value="{{ $item->name }}">
                {{ ucfirst($item->name) }}
            </option>
        @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Status <span class="text-red-500">*</span>
                                        </label>
                                        <select  wire:model="is_active" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none input-focus transition bg-white">
                                             <option value="1">Aktif</option>
    <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>


                                <!-- Tombol Aksi -->
                                <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-100">
                                    <a href="{{ route('petugas-ardi') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition text-center">
                                        Batal
                                    </a>
                                  <button
    type="submit"
    wire:loading.attr="disabled"
    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium"
>
    <i class="fas fa-save"></i>
    <span wire:loading.remove>Simpan User</span>
    <span wire:loading>Menyimpan...</span>
</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>

                <!-- footer spacer -->
                <div class="h-6"></div>

            </main>
        </div>
    </div>

</div>
