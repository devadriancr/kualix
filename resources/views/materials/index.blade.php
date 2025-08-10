<x-app-layout>
    <div class="min-h-screen py-4 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <!-- Buscador - Mejorado para móviles -->
                <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-600">
                    <form method="GET" action="{{ route('materials.index') }}" class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <div class="flex-1">
                            <x-input name="search" type="text"
                                placeholder="Buscar por código de barras, orden o parte..." value="{{ $search }}"
                                class="w-full" />
                        </div>
                        <div class="flex flex-row gap-3 sm:gap-4">
                            <x-button type="submit" class="w-full sm:w-auto justify-center">
                                Buscar
                            </x-button>
                            @if ($search)
                                <a href="{{ route('materials.index') }}"
                                    class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded text-center block sm:inline-block">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Tabla de materiales - Responsive -->
                <div class="overflow-x-auto">
                    <div class="block w-full overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        Código
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        Orden
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        Parte
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        Sec.
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        Estado
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach ($materials as $material)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $material->barcode }}
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $material->order_number }}
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $material->part_number }}
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $material->sequence }}
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full
                                            @if ($material->status == 'approved') bg-green-100 text-green-800
                                            @elseif($material->status == 'rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                                @if ($material->status == 'pending')
                                                    Pendiente
                                                @elseif($material->status == 'approved')
                                                    Aprobado
                                                @elseif($material->status == 'rejected')
                                                    Rechazado
                                                @else
                                                    {{ $material->status }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('materials.movements', $material->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 whitespace-nowrap">
                                                Ver Movimientos
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Paginación -->
                @if ($materials->hasPages())
                    <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                        {{ $materials->links() }}
                    </div>
                @endif

                @if ($materials->isEmpty())
                    <div class="px-4 sm:px-6 py-8 text-center">
                        <p class="text-gray-500 dark:text-gray-400">No se encontraron materiales.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
