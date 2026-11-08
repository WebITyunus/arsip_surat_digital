 <!-- ========== SIDEBAR ========== -->
        <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 shadow-sm flex flex-col transition-transform duration-300 ease-in-out hidden-mobile">

        <!-- Brand -->
        <div class="flex items-center gap-3 px-6 h-20 border-b border-gray-200">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-200">
                <i class="fas fa-archive text-lg"></i>
            </div>
            <span class="text-lg font-bold text-gray-800 tracking-tight">AR<span class="text-blue-600">DI</span></span>
        </div>

<nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

    {{-- Dashboard (tanpa  selalu tampil) --}}
    <a href="{{ route('dashboard') }}"
        class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
        {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-th-large w-5 text-center"></i>
        Dashboard
    </a>

    {{-- Surat Masuk --}}
    @can('surat-masuk.view')
        <a href="{{ route('surat-masuk') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('surat-masuk*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-inbox w-5 text-center"></i>
            Surat Masuk
        </a>
    @endcan

    {{-- Surat Keluar --}}
    @can('surat-keluar.view')
        <a href="{{ route('surat-keluar') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('surat-keluar*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-paper-plane w-5 text-center"></i>
            Surat Keluar
        </a>
    @endcan

    {{-- Surat Edaran --}}
    @can('surat-edaran.view')
        <a href="{{ route('surat-edaran') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('surat-edaran*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-bullhorn w-5 text-center"></i>
            Surat Edaran
        </a>
    @endcan

    {{-- Berita Acara --}}
    @can('berita-acara.view')
        <a href="{{ route('berita-acara') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('berita-acara*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-file-signature w-5 text-center"></i>
            Berita Acara
        </a>
    @endcan

    {{-- Perjanjian Kerja Sama (PKS) --}}
    @can('pks.view')
        <a href="{{ route('surat-pks') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('surat-pks*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-handshake w-5 text-center"></i>
            Perjanjian Kerja Sama
        </a>
    @endcan

    {{-- Nota Dinas --}}
    @can('nota-dinas.view')
        <a href="{{ route('surat-dinas') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('surat-dinas*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-sticky-note w-5 text-center"></i>
            Nota Dinas
        </a>
    @endcan

{{-- @if (!Auth::user()->pokja_id) --}}
    @can('spo.view')
        <a href="{{ route('surat-spo') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('surat-spo*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">

            <i class="fas fa-clipboard-list w-5 text-center"></i>
            Standar Prosedur Operasional
        </a>
    @endcan
{{-- @endif --}}

    {{-- Sertifikat --}}
    @can('sertifikat.view')
        <a href="{{ route('surat-sertifikat') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('surat-sertifikat*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-certificate w-5 text-center"></i>
            Sertifikat
        </a>
    @endcan

    {{-- Surat Keputusan --}}
    @can('agenda-sk.view')
        <a href="{{ route('surat-keputusan') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('surat-keputusan*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-file-signature w-5 text-center"></i>
            Surat Keputusan
        </a>
    @endcan

    {{-- Peraturan Direktur --}}
    @can('perdir.view')
        <a href="{{ route('surat-perdir') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('surat-perdir*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-gavel w-5 text-center"></i>
            Peraturan Direktur
        </a>
    @endcan

    @if (Auth::user()->pokja_id)
    @can('halaman.poka-user')
{{-- Simpan File Pokja --}}
<a href="{{ route('halaman-pokja-user') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
    {{ request()->routeIs('ihalaman-pokja-user*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">

    <i class="fas fa-folder-open w-5 text-center"></i>

    Simpan File Pokja Per User
</a>
@endif

    @endcan

{{-- Simpan File Pokja --}}
@can('halaman.pokja-admin')
<a href="{{ route('index-pokja') }}"
    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
    {{ request()->routeIs('index-pokja*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">

    <i class="fas fa-folder-open w-5 text-center"></i>

    Simpan File Pokja
</a>

@endcan


<hr class="my-4 border-gray-200" />

    {{-- Pengaturan (tampil untuk semua) --}}
    <a href="{{ route('profile.edit') }}"
        class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
        {{ request()->routeIs('profile.edit*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
        <i class="fas fa-cog w-5 text-center"></i>
        Pengaturan
    </a>

    {{-- Tambah Petugas --}}
    @can('users.view')
        <a href="{{ route('petugas-ardi') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('petugas-ardi*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-user-plus w-5 text-center"></i>
            Tambah Petugas
        </a>
    @endcan

    {{-- Unit Kerja --}}
    @can('unit.view')
        <a href="{{ route('unit') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('unit*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-building w-5 text-center"></i>
            Unit Kerja
        </a>
    @endcan

    @can('unit.view')
        {{-- Nama Pokja --}}
        <a href="{{ route('pokja') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('pokja*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-clipboard-list w-5 text-center"></i>
            Nama Pokja
        </a>
    @endcan

    {{-- Menu AI Assistant --}}
    <div class="pt-2 mt-2 border-t border-gray-200">
        <span class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">AI Assistant</span>

        {{-- Membuat Teks dengan AI --}}
        {{-- <a href="{{ route('ai.surat-generator') }}" wire:navigate
            class="flex items-center justify-between px-4 py-3 mt-1 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('ai.surat-generator*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <div class="flex items-center gap-3">
                <i class="fas fa-wand-magic-sparkles w-5 text-center text-blue-500"></i>
                <span>Buat Surat AI</span>
            </div>
            <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-600 text-white rounded-full animate-pulse">New</span>
        </a> --}}

        {{-- Revisi File dengan AI --}}
        <a href="{{ route('tanya-ai') }}" wire:navigate
            class="flex items-center justify-between px-4 py-3 mt-1 text-sm font-medium rounded-xl transition
            {{ request()->routeIs('tanya-ai*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
            <div class="flex items-center gap-3">
                <i class="fas fa-file-pen w-5 text-center text-indigo-500"></i>
                <span>ChatArdi</span>
            </div>
            <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-600 text-white rounded-full animate-pulse">New</span>
        </a>
    </div>



    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-xl transition">
            <i class="fas fa-sign-out-alt w-5 text-center"></i>
            Keluar
        </button>
    </form>

</nav>

        <!-- Sidebar footer -->
        <div class="border-t border-gray-200 px-6 py-4">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=Andi+Putra&background=3b82f6&color=fff&size=40" alt="avatar" class="w-9 h-9 rounded-full border-2 border-white shadow-sm" />
                <div class="text-sm">
                    <p class="font-medium text-gray-800">{{ Auth::user()->username }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </aside>
