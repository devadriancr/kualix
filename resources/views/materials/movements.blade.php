<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Información del material -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Información del Material</h3>
                    <a href="{{ route('materials.index') }}"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                        Volver
                    </a>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código de Barras</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $material->barcode }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número de Orden</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $material->order_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número de Parte</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $material->part_number }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de movimientos -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <!-- Título - Historial de Escaneos (y buscador comentado) -->
                <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Historial de Escaneos</h3>

                    {{--
                    <!-- Buscador (comentado) -->
                    <form method="GET" action="{{ route('materials.movements', $material->id) }}" class="flex items-center gap-2 flex-nowrap mb-0">
                        <x-input name="search" type="text" placeholder="Buscar por usuario, tipo o comentario..."
                            value="{{ $search }}" class="flex-grow min-w-0" />

                        <div class="flex gap-2 flex-shrink-0">
                            <x-button type="submit" class="px-4 whitespace-nowrap">
                                Buscar
                            </x-button>
                            @if ($search)
                                <a href="{{ route('materials.movements', $material->id) }}"
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 whitespace-nowrap">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </form>
                    --}}
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Fecha/Hora
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Usuario
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Área
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Tipo
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Comentario
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($movements as $movement)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                        {{ $movement->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                        {{ $movement->user->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                        {{ $movement->area->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-bold rounded-full
                                            {{ $movement->type == 'entry' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200' : '' }}
                                            {{ $movement->type == 'exit' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-200' : '' }}
                                            {{ $movement->type == 'inspection' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-200' : '' }}
                                            {{ $movement->type == 'rejection' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' : '' }}
                                            {{ $movement->type == 'validated' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-200' }}">
                                            @if ($movement->type == 'entry')
                                                Entrada
                                            @elseif($movement->type == 'exit')
                                                Salida
                                            @elseif($movement->type == 'inspection')
                                                Inspección
                                            @elseif($movement->type == 'rejection')
                                                Rechazo
                                            @elseif($movement->type == 'validated')
                                                Validado
                                            @else
                                                {{ $movement->type }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                        {{ $movement->comment ?? 'Sin comentarios' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if ($movements->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $movements->links() }}
                    </div>
                @endif

                @if ($movements->isEmpty())
                    <div class="p-8 text-center">
                        <p class="text-gray-500 dark:text-gray-400">No se encontraron movimientos para este material.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
