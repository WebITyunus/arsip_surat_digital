        {{-- <!-- ===== HEADER ===== -->
        <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-200/80 h-20 flex items-center px-4 md:px-8">
            <!-- Toggle sidebar (mobile) -->
            <button id="sidebarToggle" class="md:hidden p-2 -ml-2 rounded-lg hover:bg-gray-100 text-gray-600">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <div class="flex items-center gap-3 ml-auto">
                <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 transition">
                    <i class="fas fa-question-circle text-lg"></i>
                </button>
                <div class="hidden sm:flex items-center gap-2 pl-3 border-l border-gray-200">
                    <span class="text-sm text-gray-700 font-medium">{{ Auth::user()->username }}</span>
                    <img src="{{ asset('storage/icons/arsip.png') }}" alt="avatar" class="w-8 h-8 rounded-full border-2 border-white shadow-sm" />
                </div>
            </div>
        </header> --}}
<!-- ===== HEADER ===== -->
<header
    class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-200/80
           h-20 flex items-center px-4 md:px-8 overflow-hidden">

    <!-- 🦋 Kupu-kupu 1 -->
    <div class="absolute left-0 top-3 pointer-events-none butterfly-fly text-xl">
        🦋
    </div>

    <!-- 🦋 Kupu-kupu 2 -->
    <div class="absolute left-0 top-9 pointer-events-none butterfly-fly butterfly-delay text-sm">
        🦋
    </div>

<!-- 🐈 Kucing mengejar kupu-kupu --> <div class="absolute left-0 bottom-1 pointer-events-none cat-chase text-2xl"> 🐈 </div>


    <!-- Toggle sidebar (mobile) -->
    <button
        id="sidebarToggle"
        class="md:hidden p-2 -ml-2 rounded-lg
               hover:bg-gray-100 text-gray-600 transition">

        <i class="fas fa-bars text-xl"></i>

    </button>


    <div class="flex items-center gap-3 ml-auto relative z-10">

        <!-- Help -->
        <button
            class="p-2 rounded-lg hover:bg-gray-100
                   text-gray-600 transition-all duration-200
                   hover:scale-110">

            <i class="fas fa-question-circle text-lg"></i>

        </button>


        <!-- User -->
        <div
            class="hidden sm:flex items-center gap-2 pl-3
                   border-l border-gray-200">

            <span class="text-sm text-gray-700 font-medium">
                {{ Auth::user()->username }}
            </span>

            <img
                src="{{ asset('storage/icons/arsip.png') }}"
                alt="avatar"
                class="w-8 h-8 rounded-full border-2 border-white
                       shadow-sm transition-transform duration-300
                       hover:scale-110 hover:rotate-6"
            />

        </div>

    </div>

</header>


<style>

/* =========================================
   🦋 KUPU-KUPU
   ========================================= */

.butterfly-fly {
    position: absolute;
    left: 0;
    top: 20px;
    pointer-events: none;

    animation: butterflyFly 12s ease-in-out infinite;

    opacity: 0.7;
}

.butterfly-delay {
    animation-delay: 5s;
    top: 45px;
    opacity: 0.45;
}


/* 🦋 Terbang dari kiri → kanan */

@keyframes butterflyFly {

    0% {
        transform:
            translateX(0)
            translateY(10px)
            rotate(-8deg);
    }

    15% {
        transform:
            translateX(15vw)
            translateY(-8px)
            rotate(8deg);
    }

    30% {
        transform:
            translateX(30vw)
            translateY(8px)
            rotate(-5deg);
    }

    45% {
        transform:
            translateX(45vw)
            translateY(-12px)
            rotate(7deg);
    }

    60% {
        transform:
            translateX(60vw)
            translateY(5px)
            rotate(-6deg);
    }

    75% {
        transform:
            translateX(75vw)
            translateY(-10px)
            rotate(8deg);
    }

    90% {
        transform:
            translateX(90vw)
            translateY(5px)
            rotate(-5deg);
    }

    100% {
        transform:
            translateX(calc(100% - 40px))
            translateY(0)
            rotate(5deg);
    }

}


/* =========================================
   🐈 KUCING
   ========================================= */

.cat-chase { position: absolute; left: 0; bottom: 1px; pointer-events: none; /* * Kucing bergerak ke kanan * dan melompat-lompat. */ animation: catChase 12s linear infinite; opacity: 0.85; } /* 🐈 Jalan + lompat ke kanan */ @keyframes catChase { /* Mulai dari kiri */ 0% { transform: translateX(-50px) translateY(0) scaleX(-1); } /* Mulai mengejar */ 10% { transform: translateX(10%) translateY(0) scaleX(-1); } /* 🐾 Lompat 1 */ 18% { transform: translateX(18%) translateY(-12px) scaleX(-1); } 25% { transform: translateX(25%) translateY(0) scaleX(-1); } /* 🐾 Lompat 2 */ 33% { transform: translateX(33%) translateY(-15px) scaleX(-1); } 40% { transform: translateX(40%) translateY(0) scaleX(-1); } /* 🐾 Lompat 3 */ 48% { transform: translateX(48%) translateY(-18px) scaleX(-1); } 55% { transform: translateX(55%) translateY(0) scaleX(-1); } /* 🐾 Lompat 4 */ 63% { transform: translateX(63%) translateY(-14px) scaleX(-1); } 70% { transform: translateX(70%) translateY(0) scaleX(-1); } /* 🐾 Lompat terakhir */ 78% { transform: translateX(78%) translateY(-17px) scaleX(-1); } 85% { transform: translateX(85%) translateY(0) scaleX(-1); } /* Sampai kanan */ 100% { transform: translateX(calc(100% - 40px)) translateY(0) scaleX(-1); } }



</style>
