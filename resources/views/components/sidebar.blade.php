<aside
    class="fixed top-0 left-0 h-screen w-64 bg-white shadow-lg z-50 flex flex-col justify-between border-r border-gray-200">

    <!-- Encabezado con borde sutil -->
    <div>
        <div class="p-6 border-b border-gray-100">
            <a href="{{ route('dashboard') }}"
                class="text-2xl font-bold text-center block transition-colors hover:opacity-80">
                <span class="text-red-600">Y</span>
                <span class="mx-2 text-blue-800">K</span>
                <span class="text-blue-800">M</span>
            </a>
        </div>

        <!-- Navegación -->
        <nav class="mt-6 px-4 space-y-1">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-3 py-3 rounded-r-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('materials.scan') }}"
                class="{{ request()->routeIs('materials.scan') ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-3 py-3 rounded-r-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                </svg>
                <span>Escaneo de Etiqueta</span>
            </a>

            <a href="{{ route('materials.validate') }}"
                class="{{ request()->routeIs('materials.validate') ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-3 py-3 rounded-r-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                <span>Validar Etiqueta</span>
            </a>

            <a href="{{ route('materials.index') }}"
                class="{{ request()->routeIs('materials.index') ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-3 py-3 rounded-r-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <span>Escaneos</span>
            </a>

            <!-- Submenú -->
            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-3 py-3 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors focus:outline-none">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>
                        <span>Reportes</span>
                    </div>
                    <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-cloak class="pl-10 mt-1 space-y-1">
                    <a href="#" class="block px-2 py-2 rounded-lg text-gray-600 hover:bg-gray-50">Diario</a>
                    <a href="#" class="block px-2 py-2 rounded-lg text-gray-600 hover:bg-gray-50">Mensual</a>
                    <a href="#" class="block px-2 py-2 rounded-lg text-gray-600 hover:bg-gray-50">Anual</a>
                </div>
            </div>

            <!-- Perfil -->
            <a href="{{ route('profile.show') }}"
                class="{{ request()->routeIs('profile.show') ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-500' : 'text-gray-600 hover:bg-gray-50' }} flex items-center gap-3 px-3 py-3 rounded-r-lg transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span>Perfil</span>
            </a>

            <!-- Otro Enlace -->
            <a href="#"
                class="flex items-center gap-3 px-3 py-3 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <span>Otro Enlace</span>
            </a>

        </nav>
    </div>

    <!-- Cerrar sesión -->
    <div class="p-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-3 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                <span>Cerrar sesión</span>
            </button>
        </form>
    </div>

</aside>
