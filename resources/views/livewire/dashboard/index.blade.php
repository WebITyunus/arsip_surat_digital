             <div>
             <!-- Breadcrumb -->
                <div class="text-sm text-gray-500 mb-6 flex items-center gap-2">
                    <i class="fas fa-home text-blue-500 text-xs"></i>
                    <span>/</span>
                    <span class="text-gray-700 font-medium">Dashboard</span>
                </div>

                <!-- Page title -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">
                            👋 Selamat Datang, {{ Auth::user()->username }}
                        </h1>
                        <p class="text-gray-500 text-sm mt-1">Ringkasan arsip surat digital instansi Anda</p>
                    </div>

                </div>

                <!-- ===== STATS CARDS ===== -->
                {{-- <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
                    <!-- Total Surat -->
                    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100/80">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Surat</p>
                                <p class="text-2xl font-bold text-gray-800 mt-1">1.284</p>
                            </div>
                            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <i class="fas fa-inbox text-lg"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 mt-3 text-xs text-green-600">
                            <i class="fas fa-arrow-up"></i>
                            <span>+12%</span>
                            <span class="text-gray-400">dari bulan lalu</span>
                        </div>
                    </div>

                    <!-- Surat Masuk -->
                    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100/80">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Surat Masuk</p>
                                <p class="text-2xl font-bold text-gray-800 mt-1">342</p>
                            </div>
                            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <i class="fas fa-arrow-down text-lg"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 mt-3 text-xs text-green-600">
                            <i class="fas fa-arrow-up"></i>
                            <span>+8%</span>
                            <span class="text-gray-400">dari bulan lalu</span>
                        </div>
                    </div>

                    <!-- Surat Keluar -->
                    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100/80">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Surat Keluar</p>
                                <p class="text-2xl font-bold text-gray-800 mt-1">198</p>
                            </div>
                            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                <i class="fas fa-arrow-up text-lg"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 mt-3 text-xs text-red-500">
                            <i class="fas fa-arrow-down"></i>
                            <span>-3%</span>
                            <span class="text-gray-400">dari bulan lalu</span>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="stat-card bg-white rounded-2xl p-5 shadow-sm border border-gray-100/80">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Menunggu Disposisi</p>
                                <p class="text-2xl font-bold text-gray-800 mt-1">27</p>
                            </div>
                            <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                                <i class="fas fa-clock text-lg"></i>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 mt-3 text-xs text-rose-500">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Perlu tindakan</span>
                        </div>
                    </div>
                </div> --}}


                <!-- footer spacer -->
                <div class="h-6"></div>
</div>
