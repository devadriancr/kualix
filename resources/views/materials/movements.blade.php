<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Información del material -->
            <div class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Información del Material</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código de
                                Barras</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $material->barcode }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número de
                                Orden</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $material->order_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número de
                                Parte</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $material->part_number }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de movimientos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                <!-- Buscador -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-600">
                    <form method="GET" action="{{ route('materials.movements', $material->id) }}" class="flex gap-4">
                        <div class="flex-1">
                            <x-input name="search" type="text"
                                placeholder="Buscar por usuario, tipo o comentario..." value="{{ $search }}"
                                class="w-full" />
                        </div>
                        <x-button type="submit">
                            Buscar
                        </x-button>
                        @if ($search)
                            <a href="{{ route('materials.movements', $material->id) }}"
                                class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded">
                                Limpiar
                            </a>
                        @endif
                    </form>
                    <a href="{{ route('materials.index') }}"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white font-bold rounded">
                        Volver
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Fecha/Hora
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Usuario
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Área
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tipo
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Comentario
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                            @foreach ($movements as $movement)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $movement->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $movement->user->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $movement->area->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if ($movement->type == 'entry') bg-blue-100 text-blue-800
                                        @elseif($movement->type == 'exit') bg-orange-100 text-orange-800
                                        @elseif($movement->type == 'inspection') bg-purple-100 text-purple-800
                                        @elseif($movement->type == 'rejection') bg-red-100 text-red-800
                                        @elseif($movement->type == 'validated') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
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
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                        {{ $movement->comment ?? 'Sin comentarios' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if ($movements->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                        {{ $movements->links() }}
                    </div>
                @endif

                @if ($movements->isEmpty())
                    <div class="px-6 py-8 text-center">
                        <p class="text-gray-500 dark:text-gray-400">No se encontraron movimientos para este material.
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
