<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>Login | Arsip Surat Digital</title>

    @vite([ 'resources/js/app.js'])
     <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>


<body class="min-h-screen bg-slate-100 antialiased">


    <main class="min-h-screen flex">


        {{-- =========================================================
            LEFT SIDE - BRANDING
        ========================================================== --}}

        <section
            class="relative hidden lg:flex lg:w-1/2
                   overflow-hidden
                   bg-linear-to-br
                   from-slate-950
                   via-blue-950
                   to-blue-800"
        >

            {{-- Background decoration --}}
            <div
                class="absolute -top-32 -left-32
                       size-96
                       rounded-full
                       bg-cyan-400/10
                       blur-3xl"
            ></div>

            <div
                class="absolute -bottom-40 -right-20
                       size-125
                       rounded-full
                       bg-blue-400/10
                       blur-3xl"
            ></div>


            {{-- Grid pattern --}}
            <div
                class="absolute inset-0 opacity-[0.06]"
                style="
                    background-image:
                        linear-gradient(rgba(255,255,255,.7) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(255,255,255,.7) 1px, transparent 1px);
                    background-size: 40px 40px;
                "
            ></div>


            {{-- Content --}}
            <div
                class="relative z-10
                       flex flex-col justify-between
                       w-full
                       p-12 xl:p-16"
            >

<div class="flex items-center gap-5">

<div
    class="flex size-44 shrink-0
           items-center justify-center
           rounded-3xl
           bg-white/10
           border border-white/15
           backdrop-blur-sm"
>
    <img
        src="{{ asset('storage/icons/arsip.png') }}"
        alt="Logo"
        class="size-[220px] object-contain"
    >
</div>

    <div>

        <p class="text-2xl font-bold text-white">
            Arsip Surat Digital
        </p>

        <p class="mt-1 text-base text-blue-200">
            Sistem Informasi Arsip
        </p>

    </div>

</div>


                {{-- Main Branding --}}
                <div class="max-w-xl">

                    {{-- Icon --}}
                    {{-- <div
                        class="mb-7 flex size-16
                               items-center justify-center
                               rounded-2xl
                               bg-cyan-400/10
                               border border-cyan-300/20"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="size-8 text-cyan-300"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.75 5.25A2.25 2.25 0 016 3h12a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0118 21H6a2.25 2.25 0 01-2.25-2.25V5.25z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M7.5 7.5h9M7.5 11.25h9M7.5 15h5.25"
                            />
                        </svg>

                    </div> --}}


                    <h1
                        class="text-4xl xl:text-5xl
                               font-bold
                               leading-tight
                               tracking-tight
                               text-white"
                    >
                        Kelola Arsip Surat
                        <span class="text-cyan-300">
                            Lebih Mudah.
                        </span>
                    </h1>


                    <p
                        class="mt-6
                               max-w-lg
                               text-base
                               leading-7
                               text-blue-100/75"
                    >
                        Sistem arsip surat digital untuk membantu
                        pengelolaan, pencarian, penyimpanan, dan
                        dokumentasi surat secara lebih terstruktur
                        dan efisien.
                    </p>


                    {{-- Feature --}}
                    <div class="mt-9 grid grid-cols-2 gap-4">

                        <div
                            class="flex items-center gap-3
                                   rounded-xl
                                   border border-white/10
                                   bg-white/5
                                   px-4 py-3
                                   backdrop-blur-sm"
                        >

                            <div
                                class="flex size-9
                                       items-center justify-center
                                       rounded-lg
                                       bg-cyan-400/10"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-cyan-300"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 3.75l7.5 3v5.25c0 4.5-3 7.875-7.5 9-4.5-1.125-7.5-4.5-7.5-9V6.75l7.5-3z"
                                    />
                                </svg>

                            </div>

                            <span class="text-sm text-white/80">
                                Aman & Terstruktur
                            </span>

                        </div>


                        <div
                            class="flex items-center gap-3
                                   rounded-xl
                                   border border-white/10
                                   bg-white/5
                                   px-4 py-3
                                   backdrop-blur-sm"
                        >

                            <div
                                class="flex size-9
                                       items-center justify-center
                                       rounded-lg
                                       bg-cyan-400/10"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="size-5 text-cyan-300"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 21l-4.35-4.35m2.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"
                                    />
                                </svg>

                            </div>

                            <span class="text-sm text-white/80">
                                Pencarian Cepat
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Footer --}}
                <div>

                    <p class="text-sm text-blue-200/50">
                        Sistem Informasi Arsip Surat Digital
                    </p>

                </div>

            </div>

        </section>



        {{-- =========================================================
            RIGHT SIDE - LOGIN
        ========================================================== --}}

        <section
            class="flex w-full lg:w-1/2
                   items-center justify-center
                   bg-slate-50
                   px-5 py-10
                   sm:px-8"
        >

            <div class="w-full max-w-md">


                {{-- Mobile Logo --}}
                <div class="mb-8 flex justify-center lg:hidden">

                    <div
                        class="flex size-16
                               items-center justify-center
                               rounded-2xl
                               bg-white
                               border border-slate-200
                               shadow-lg"
                    >

                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="Logo"
                            class="size-11 object-contain"
                        >

                    </div>

                </div>


                {{-- Header --}}
                <div class="mb-8">

                    <p
                        class="mb-2 text-sm
                               font-semibold
                               text-blue-600"
                    >
                        ARSIP SURAT DIGITAL
                    </p>


                    <h2
                        class="text-3xl
                               font-bold
                               tracking-tight
                               text-slate-900"
                    >
                        Selamat Datang 👋
                    </h2>


                    <p
                        class="mt-2
                               text-sm
                               leading-6
                               text-slate-500"
                    >
                        Masuk ke akun Anda untuk mengakses
                        sistem arsip surat digital.
                    </p>

                </div>



                {{-- Session Status --}}
                @if (session('status'))

                    <div
                        class="mb-5
                               rounded-xl
                               border border-emerald-200
                               bg-emerald-50
                               px-4 py-3
                               text-sm
                               text-emerald-700"
                    >
                        {{ session('status') }}
                    </div>

                @endif



                {{-- Validation Summary --}}
                @if ($errors->any())

                    <div
                        class="mb-5
                               rounded-xl
                               border border-red-200
                               bg-red-50
                               px-4 py-3
                               text-sm
                               text-red-700"
                    >
                        {{ $errors->first() }}
                    </div>

                @endif



                {{-- Login Form --}}
                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="space-y-5"
                >

                    @csrf


                    {{-- Username --}}
                    <div>

                        <label
                            for="username"
                            class="mb-2 block
                                   text-sm
                                   font-semibold
                                   text-slate-700"
                        >
                            Username
                        </label>


                        <div class="relative">

                            {{-- User Icon --}}
                            <div
                                class="pointer-events-none
                                       absolute inset-y-0 left-0
                                       flex items-center pl-4
                                       text-slate-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="size-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4.5 20.25a7.5 7.5 0 0115 0"
                                    />
                                </svg>

                            </div>


                            <input
                                id="username"
                                type="text"
                                name="username"
                                value="{{ old('username') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Masukkan username"
                                class="block w-full
                                       rounded-xl
                                       border border-slate-200
                                       bg-white
                                       py-3.5
                                       pl-12 pr-4
                                       text-sm
                                       text-slate-900
                                       placeholder:text-slate-400
                                       shadow-sm
                                       outline-none
                                       transition
                                       focus:border-blue-500
                                       focus:ring-4
                                       focus:ring-blue-500/10"
                            >

                        </div>


                        @error('username')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    {{-- Password --}}
                    <div x-data="{ show: false }">

                        <label
                            for="password"
                            class="mb-2 block
                                   text-sm
                                   font-semibold
                                   text-slate-700"
                        >
                            Password
                        </label>


                        <div class="relative">

                            {{-- Lock Icon --}}
                            <div
                                class="pointer-events-none
                                       absolute inset-y-0 left-0
                                       flex items-center pl-4
                                       text-slate-400"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="size-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.5 10.5V7.5a4.5 4.5 0 10-9 0v3"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 10.5h12a1.5 1.5 0 011.5 1.5v6A1.5 1.5 0 0118 19.5H6A1.5 1.5 0 014.5 18v-6A1.5 1.5 0 016 10.5z"
                                    />

                                </svg>

                            </div>


                            <input
                                id="password"
                                x-bind:type="show ? 'text' : 'password'"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                class="block w-full
                                       rounded-xl
                                       border border-slate-200
                                       bg-white
                                       py-3.5
                                       pl-12 pr-12
                                       text-sm
                                       text-slate-900
                                       placeholder:text-slate-400
                                       shadow-sm
                                       outline-none
                                       transition
                                       focus:border-blue-500
                                       focus:ring-4
                                       focus:ring-blue-500/10"
                            >


                            {{-- Toggle Password --}}
                            <button
                                type="button"
                                @click="show = !show"
                                class="absolute inset-y-0 right-0
                                       flex items-center
                                       pr-4
                                       text-slate-400
                                       transition
                                       hover:text-blue-600"
                                :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                            >

                                {{-- Eye --}}
                                <svg
                                    x-show="!show"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="size-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />

                                </svg>


                                {{-- Eye Slash --}}
                                <svg
                                    x-show="show"
                                    x-cloak
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="size-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 3l18 18"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M10.584 10.587a2 2 0 002.828 2.828"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9.363 5.365A9 9 0 0112 5c6 0 9.75 7 9.75 7a17.3 17.3 0 01-3.19 4.34"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6.228 6.228A17.3 17.3 0 002.25 12s3.75 7 9.75 7a9 9 0 004.228-1.06"
                                    />

                                </svg>

                            </button>

                        </div>


                        @error('password')

                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>



                    {{-- Remember Me + Forgot Password --}}
                    <div
                        class="flex items-center
                               justify-between gap-4"
                    >

                        <label
                            for="remember"
                            class="flex cursor-pointer
                                   items-center gap-2"
                        >

                            <input
                                id="remember"
                                type="checkbox"
                                name="remember"
                                class="size-4
                                       rounded
                                       border-slate-300
                                       text-blue-600
                                       shadow-sm
                                       focus:ring-blue-500"
                            >

                            <span
                                class="text-sm
                                       text-slate-600"
                            >
                                Ingat saya
                            </span>

                        </label>


                    </div>



                    {{-- Login Button --}}
                    <button
                        type="submit"
                        class="group
                               flex w-full
                               items-center
                               justify-center
                               gap-2
                               rounded-xl
                               bg-linear-to-r
                               from-blue-600
                               to-cyan-600
                               px-4 py-3.5
                               text-sm
                               font-semibold
                               text-white
                               shadow-lg
                               shadow-blue-500/20
                               transition-all
                               duration-200
                               hover:from-blue-700
                               hover:to-cyan-700
                               hover:shadow-blue-500/30
                               active:scale-[0.98]"
                    >

                        <span>
                            Masuk ke Sistem
                        </span>


                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="size-5
                                   transition-transform
                                   duration-200
                                   group-hover:translate-x-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                            />
                        </svg>

                    </button>

                </form>



                {{-- Bottom Info --}}
                <div
                    class="mt-8
                           border-t
                           border-slate-200
                           pt-6"
                >

                    <div
                        class="flex items-center
                               justify-center gap-2
                               text-xs
                               text-slate-400"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="size-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3.75l7.5 3v5.25c0 4.5-3 7.875-7.5 9-4.5-1.125-7.5-4.5-7.5-9V6.75l7.5-3z"
                            />
                        </svg>

                        <span>
                            Akses sistem terlindungi
                        </span>

                    </div>

                </div>


            </div>

        </section>

    </main>

</body>

</html>
