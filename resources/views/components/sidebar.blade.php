<!-- resources/views/components/sidebar.blade.php -->

<aside class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-indigo-600 to-indigo-800 text-white shadow-lg z-50 flex flex-col justify-between">

    <!-- Encabezado -->
    <div>
        <div class="p-6 text-2xl text-center font-bold border-b border-indigo-500">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-200">Y K M</a>
        </div>

        <!-- Navegación -->
        <nav class="mt-6 px-4 space-y-2">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l9-9 9 9M4 10v10h16V10" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Perfil -->
            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span>Perfil</span>
            </a>

            <!-- Submenú -->
            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-3 py-2 rounded hover:bg-indigo-700 transition focus:outline-none">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 7a2 2 0 012-2h5l2 2h7a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                        </svg>
                        <span>Reportes</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform duration-300"
                        fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-cloak class="pl-10 mt-1 space-y-1">
                    <a href="#" class="block px-2 py-1 rounded hover:bg-indigo-700">Diario</a>
                    <a href="#" class="block px-2 py-1 rounded hover:bg-indigo-700">Mensual</a>
                    <a href="#" class="block px-2 py-1 rounded hover:bg-indigo-700">Anual</a>
                </div>
            </div>

            <!-- Otro Enlace -->
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-indigo-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span>Otro Enlace</span>
            </a>

        </nav>
    </div>

    <!-- Cerrar sesión al fondo -->
    <div class="p-4 border-t border-indigo-500">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2 rounded hover:bg-red-600 transition text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                <span>Cerrar sesión</span>
            </button>
        </form>
    </div>

</aside>
