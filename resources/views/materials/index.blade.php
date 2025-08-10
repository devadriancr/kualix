<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">

                <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                    <form method="GET" action="{{ route('materials.index') }}"
                        class="flex items-center gap-2 flex-nowrap">
                        <x-input name="search" type="text" placeholder="Buscar por código, orden o parte..."
                            value="{{ $search }}" class="flex-grow min-w-0" />

                        <div class="flex gap-2 flex-shrink-0">
                            <x-button type="submit" class="px-4 whitespace-nowrap">
                                Buscar
                            </x-button>
                            @if ($search)
                                <a href="{{ route('materials.index') }}"
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
                                    Número de Orden
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Sequencia
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Cantidad
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Estado
                                </th>
                                <th class="px-4 py-3 text-left text-gray-500 dark:text-gray-400 uppercase">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($materials as $material)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                        {{ $material->order_number }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                        @php
                                            $sequence = $material->sequence;
                                            $current = (int) substr($sequence, 0, 3);
                                            $total = (int) substr($sequence, 3, 3);
                                        @endphp
                                        {{ $current }} de {{ $total }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                        {{ (int) $material->standard_pack }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-bold rounded-full
                                            {{ $material->status == 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : '' }}
                                            {{ $material->status == 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' : '' }}
                                            {{ $material->status == 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200' : '' }}">
                                            @if ($material->status == 'pending')
                                                Pendiente
                                            @elseif($material->status == 'approved')
                                                Aprobado
                                            @elseif($material->status == 'rejected')
                                                Rechazado
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <a href="{{ route('materials.movements', $material->id) }}"
                                            class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Movimientos
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if ($materials->hasPages())
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        {{ $materials->links() }}
                    </div>
                @endif

                @if ($materials->isEmpty())
                    <div class="p-8 text-center">
                        <p class="text-gray-500 dark:text-gray-400">No se encontraron materiales</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
