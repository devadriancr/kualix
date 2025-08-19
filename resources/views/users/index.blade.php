<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">

                <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                        Gestión de Usuarios
                    </h2>
                    <a href="{{ route('users.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nuevo Usuario
                    </a>
                </div>

                <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                    <form method="GET" action="{{ route('users.index') }}" class="flex items-center gap-2 flex-nowrap">
                        <x-input name="search" type="text" placeholder="Buscar por nombre o email..."
                                 value="{{ $search }}" class="flex-grow min-w-0" />

                        <div class="flex gap-2 flex-shrink-0">
                            <x-button type="submit" class="px-4 whitespace-nowrap">
                                Buscar
                            </x-button>
                            @if ($search)
                                <a href="{{ route('users.index') }}"
                                   class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 whitespace-nowrap">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Nombre
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Email
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Roles
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($user->roles as $role)
                                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex gap-2">
                                            <a href="{{ route('users.edit', $user) }}"
                                               class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                                               title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                                        title="Eliminar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $users->links() }}
                    </div>
                @endif

                @if ($users->isEmpty())
                    <div class="p-8 text-center">
                        <p class="text-gray-500 dark:text-gray-400">No se encontraron usuarios</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
