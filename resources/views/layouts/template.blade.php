<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Arsip Surat Digital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css'])
    <style>
        /* custom scroll & smooth transition */
        * {
            scroll-behavior: smooth;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background: #b0b0b0;
            border-radius: 8px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #888;
        }

        /* sidebar toggle for mobile */
        #sidebar {
            transition: transform 0.3s ease;
        }
        #sidebar.hidden-mobile {
            transform: translateX(-100%);
        }
        @media (min-width: 768px) {
            #sidebar.hidden-mobile {
                transform: translateX(0);
            }
        }

        /* card hover */
        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
        }

        /* table row hover */
        .table-row-hover:hover {
            background-color: #f8fafc;
        }

        /* badge status */
        .badge {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.01em;
        }
    </style>

</head>
<body>

    <div class="flex h-screen bg-gray-50 font-sans antialiased">

@include('components.sidebar-dashboard')
    <!-- ========== MAIN CONTENT ========== -->
    <div class="flex-1 flex flex-col md:ml-64">
@include('components.header-dashboard')


        <!-- ===== PAGE CONTENT ===== -->
        <main class="flex-1 p-4 md:p-8 overflow-y-auto">

                {{ $slot }}

        </main>
    </div>
</div>

<!-- ========== SIDEBAR TOGGLE SCRIPT ========== -->
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('hidden-mobile');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 768) {
            const isClickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
            if (!isClickInside && !sidebar.classList.contains('hidden-mobile')) {
                sidebar.classList.add('hidden-mobile');
            }
        }
    });

    // Reset on resize to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('hidden-mobile');
        } else {
            sidebar.classList.add('hidden-mobile');
        }
    });


</script>

@if (session('success'))
    <script>
        document.addEventListener('livewire:navigated', () => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                timer: 2500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        });
    </script>
@endif

<script>
    document.addEventListener('livewire:init', () => {

        Livewire.on('notify', (event) => {

            Swal.fire({
                icon: event.type,
                title: event.title,
                text: event.message,
                timer: event.type === 'success' ? 2500 : undefined,
                showConfirmButton: event.type !== 'success',
                confirmButtonText: 'OK',
                toast: event.type === 'success',
                position: event.type === 'success'
                    ? 'top-end'
                    : 'center'
            });

        });

    });
</script>

@if (session('error'))
    <script>
        document.addEventListener('livewire:navigated', () => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: @json(session('error')),
                showConfirmButton: true,
                confirmButtonText: 'OK',
                position: 'center'
            });
        });
    </script>
@endif


</body>
</html>
