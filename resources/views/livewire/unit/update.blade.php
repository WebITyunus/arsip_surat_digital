
<div>

    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex items-center gap-2">
        <i class="fas fa-home text-blue-500 text-xs"></i>
        <span>/</span>
        <a href="#" class="hover:text-gray-700">Dashboard</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">Unit Kerja</span>
    </div>


    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-3">
            <i class="fas fa-building text-blue-600"></i>
            Unit Kerja
        </h1>

        <p class="text-gray-500 text-sm mt-1">
            Kelola daftar unit/instansi pengirim dan penerima surat
        </p>
    </div>


    <!-- ====================================================== -->
    <!-- FORM TAMBAH UNIT -->
    <!-- ====================================================== -->

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 mb-6 overflow-hidden">

        <!-- Form Header -->
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600
                            flex items-center justify-center">

                    <i class="fas fa-plus"></i>

                </div>

                <div>
                    <h2 class="text-base font-semibold text-gray-800">
                        Tambah Unit Kerja
                    </h2>

                    <p class="text-xs text-gray-500 mt-0.5">
                        Tambahkan unit kerja baru ke dalam sistem.
                    </p>
                </div>

            </div>

        </div>


        <!-- Form Body -->
        <form wire:submit="update" class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- Kode Unit -->
                <div>

                    <label
                        for="kode_unit"
                        class="block text-sm font-medium text-gray-700 mb-2">

                        Kode Unit

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                            <i class="fas fa-hashtag text-gray-400 text-sm"></i>

                        </div>

                        <input
                            type="text"
                            id="kode_unit"
                            wire:model="kode_unit"
                            placeholder="Contoh: SDM-01"
                            class="w-full pl-10 pr-4 py-2.5
                                   border border-gray-200 rounded-xl
                                   text-sm text-gray-700
                                   placeholder-gray-400
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-100
                                   outline-none
                                   transition-all duration-200">

                    </div>

                    @error('kode_unit')
                        <p class="mt-1.5 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Nama Unit -->
                <div>

                    <label
                        for="nama_unit"
                        class="block text-sm font-medium text-gray-700 mb-2">

                        Nama Unit

                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">

                            <i class="fas fa-building text-gray-400 text-sm"></i>

                        </div>

                        <input
                            type="text"
                            id="nama_unit"
                            wire:model="nama_unit"
                            placeholder="Contoh: Bagian Sumber Daya Manusia"
                            class="w-full pl-10 pr-4 py-2.5
                                   border border-gray-200 rounded-xl
                                   text-sm text-gray-700
                                   placeholder-gray-400
                                   focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-100
                                   outline-none
                                   transition-all duration-200">

                    </div>

                    @error('nama_unit')
                        <p class="mt-1.5 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Status -->
                <div>

                    <label
                        for="status"
                        class="block text-sm font-medium text-gray-700 mb-2">

                        Status Unit

                    </label>


                    @error('status')
                        <p class="mt-1.5 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Tombol -->
                <div class="flex items-end justify-end gap-2">

                    <button
                        type="reset"
                        class="inline-flex items-center justify-center gap-2
                               px-4 py-2.5
                               bg-white
                               border border-gray-200
                               hover:bg-gray-50
                               text-gray-700
                               text-sm font-medium
                               rounded-xl
                               transition-all duration-200">

                        <i class="fas fa-rotate-left"></i>

                        Reset

                    </button>


                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center gap-2
                               px-2 py-2.5
                               bg-blue-600
                               hover:bg-blue-700
                               disabled:opacity-60
                               disabled:cursor-not-allowed
                               text-white
                               text-sm font-semibold
                               rounded-xl
                               shadow-sm shadow-blue-200
                               transition-all duration-200
                               hover:-translate-y-0.5">

                        <span wire:loading.remove>
                            <i class="fas fa-save"></i>
                            Simpan Unit
                        </span>

                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin"></i>
                            Menyimpan...
                        </span>

                    </button>

                </div>

            </div>

        </form>

    </div>


    <!-- Footer Spacer -->
    <div class="h-4"></div>

</div>

