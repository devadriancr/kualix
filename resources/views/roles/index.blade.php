<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                         {{ __('Listado de Roles') }}
                    </p>
                    <a href="{{ route('roles.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700 transition">
                        <!-- icono + -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nuevo Rol
                    </a>
                </div>

                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 m-4 rounded">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 m-4 rounded">
                    {{ session('error') }}
                </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Permisos</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($roles as $role)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $role->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($role->permissions->isEmpty())
                                    <span class="text-gray-400 text-xs">Sin permisos</span>
                                    @else
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($role->permissions as $perm)
                                        <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs font-semibold">
                                            {{ $perm->name }}
                                        </span>
                                        @endforeach
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('roles.edit', $role->id) }}"
                                        class="inline-flex items-center text-indigo-600 hover:text-indigo-900 dark:hover:text-indigo-400 font-medium">
                                        <!-- Heroicon: Pencil -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536M9 13l6-6 3 3-6 6H9v-3z" />
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este rol?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center text-red-600 hover:text-red-900 dark:hover:text-red-400 font-medium">
                                            <!-- Heroicon: Trash -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                    No hay roles registrados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
