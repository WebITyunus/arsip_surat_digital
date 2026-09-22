<div>
<div>

            <!-- Breadcrumb -->
            <div class="text-sm text-gray-500 mb-6 flex items-center gap-2">
                <i class="fas fa-home text-blue-500 text-xs"></i>
                <span>/</span>
                <span class="text-gray-700 font-medium">Dashboard</span>
                <span>/</span>
                <span>Arsip Perjanjian Kerja Sama</span>
            </div>

            <!-- Page title -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">📄 Arsip Perjanjian Kerja Sama</h1>
                    <p class="text-gray-500 text-sm mt-1">Kelola seluruh surat Perjanjian Kerja Sama instansi Anda</p>
                </div>
                <div class="flex gap-3 mt-4 sm:mt-0">

                   <a href="/tambah-petugas"
        class="open-modal-btn inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition shadow-sm shadow-blue-200">
  <i class="fas fa-plus-circle"></i> Arsip Baru
</a>
                </div>
            </div>


            <!-- ===== FILTER & TABLE ===== -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">

         <!-- Search bar -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 md:p-6 border-b border-gray-100">

    <div class="relative w-full sm:max-w-md">

        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
<form  wire:submit.prevent="search">
        <input
            type="text"
            wire:model.live.debounce.300ms="query"
            placeholder="Cari nomor surat..."
            class="w-full pl-10 pr-4 py-2.5 bg-gray-100 border-0 rounded-xl text-sm text-gray-700 focus:ring-2 focus:ring-blue-500/40 outline-none"
        >
</form>

    </div>



</div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-4 md:px-6 py-4 text-left font-medium">
                                </th>
                                <th class="px-4 md:px-6 py-4 text-left font-medium">name</th>
                                <th class="px-4 md:px-6 py-4 text-left font-medium hidden sm:table-cell">user name</th>
                                <th class="px-4 md:px-6 py-4 text-left font-medium">email</th>
                                <th class="px-4 md:px-6 py-4 text-right font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <!-- Row 1 -->
                            @forelse ($datauser as $data )
                                    <tr class="table-row-hover">
                                <td class="px-4 md:px-6 py-4">{{ $datauser->firstItem() + $loop->index }}</td>
                                <td class="px-4 md:px-6 py-4 font-medium text-gray-800">{{ $data->name }}</td>
                                <td class="px-4 md:px-6 py-4 hidden sm:table-cell text-gray-600">{{ $data->username }}</td>
                                <td class="px-4 md:px-6 py-4 text-gray-700 max-w-[180px] truncate">{{ $data->email }}</td>
                                <td class="px-4 md:px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('edit-petugas',$data) }}" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-500 transition"><i class="fas fa-edit"></i></a>
                                        <button  type="button"
    wire:click="delete({{ $data->id }})"
    wire:confirm="Yakin ingin menghapus surat ini?" class="p-1.5 rounded-lg hover:bg-red-50 text-red-400 transition"><i class="fas fa-trash-alt"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @empty

                            @endforelse


                        </tbody>
                    </table>
                </div>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-4 md:p-6 border-t border-gray-100">

    <div class="text-sm text-gray-500">
        Menampilkan
        <span class="font-medium text-gray-700">
            {{ $datauser->firstItem() ?? 0 }}
        </span>
        sampai
        <span class="font-medium text-gray-700">
            {{ $datauser->lastItem() ?? 0 }}
        </span>
        dari
        <span class="font-medium text-gray-700">
            {{ $datauser->total() }}
        </span>
        surat
    </div>

    <div>
        {{ $datauser->links('livewire.pagination') }}
    </div>

</div>       </div>

            </div>

            <!-- footer spacer -->
            <div class="h-4"></div>

        </main>
    </div>

</div>


</div>
