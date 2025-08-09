<x-app-layout>
    <div class="flex items-center justify-center min-h-screen py-12">
        <div class="w-full max-w-2xl">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <form method="POST" action="{{ route('materials.validate') }}" id="scanForm">
                        @csrf

                        <div class="flex items-end gap-4">
                            <div class="flex-1">
                                <x-label for="scanInput" value="{{ 'Escanea etiqueta' }}"
                                    class="block text-sm font-medium text-gray-700" />
                                <x-input id="scanInput" name="scanInput" type="text" class="block w-full mt-1"
                                    placeholder="Escanea aquí..." autofocus required />
                                <x-input-error for="scanInput" class="mt-2" />
                            </div>

                            <div class="mb-1">
                                <x-button type="submit" class="h-[42px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Validar') }}
                                </x-button>
                            </div>
                        </div>
                    </form>

                    @if (session('success') && session('material'))
                        <div class="p-6 mt-6 bg-white rounded-lg shadow-sm border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-200">
                                Información del material</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                                <div class="p-3 rounded-md">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Número de
                                        orden</p>
                                    <p class="text-base font-semibold text-gray-800 mt-1">
                                        {{ session('material')->order_number }}</p>
                                </div>

                                <div class="p-3 rounded-md">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Secuencia</p>
                                    <p class="text-base font-semibold text-gray-800 mt-1">
                                        <span
                                            class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full text-sm font-medium">
                                            @php
                                                $sequence = session('material')->sequence;
                                                $current = (int) substr($sequence, 0, 3);
                                                $total = (int) substr($sequence, 3, 3);
                                            @endphp
                                            {{ $current }} de {{ $total }}
                                        </span>
                                    </p>
                                </div>

                                <div class="p-3 rounded-md">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</p>
                                    <p class="text-base font-semibold text-gray-800 mt-1">
                                        {{ (int) session('material')->standard_pack }}
                                    </p>
                                </div>
                            </div>

                            @if (session('lastMovement'))
                                <div class="mt-8 pt-6 border-t border-gray-200">
                                    <h4 class="text-md font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-200">
                                        Último movimiento</h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="p-3 rounded-md">
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Área
                                            </p>
                                            <p class="text-base font-semibold text-gray-800 mt-1">
                                                {{ session('lastMovement')->area->name ?? 'Sin Área' }}
                                                {{-- <span
                                                    class="block text-xs text-gray-500">{{ session('lastMovement')->area->department->name ?? 'Sin Departamento' }}</span> --}}
                                            </p>
                                        </div>

                                        <div class="p-3 rounded-md">
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Usuario</p>
                                            <p class="text-base font-semibold text-gray-800 mt-1">
                                                {{ session('lastMovement')->user->name ?? 'N/A' }}</p>
                                        </div>

                                        <div class="p-3 rounded-md">
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo
                                            </p>
                                            <p class="text-base font-semibold text-gray-800 mt-1">
                                                @php
                                                    $type = session('lastMovement')->type ?? 'N/A';
                                                    $typeTranslations = [
                                                        'entry' => 'Entrada',
                                                        'exit' => 'Salida',
                                                        'inspection' => 'Inspección',
                                                        'rejection' => 'Rechazo',
                                                        'validated' => 'Validado',
                                                    ];
                                                    $translatedType = $typeTranslations[$type] ?? $type;

                                                    $typeColors = [
                                                        'entry' => 'bg-blue-100 text-blue-800',
                                                        'exit' => 'bg-blue-100 text-blue-800',
                                                        'inspection' => 'bg-yellow-100 text-yellow-800',
                                                        'rejection' => 'bg-red-100 text-red-800',
                                                        'validated' => 'bg-green-100 text-green-800',
                                                    ];
                                                    $colorClasses = $typeColors[$type] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span
                                                    class="px-3 py-1 rounded-full text-sm font-semibold {{ $colorClasses }}">
                                                    {{ $translatedType }}
                                                </span>
                                            </p>
                                        </div>

                                        <div class="p-3 rounded-md">
                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha
                                            </p>
                                            <p class="text-base font-semibold text-gray-800 mt-1">
                                                {{ session('lastMovement')->created_at->format('d/m/Y H:i:s') }}</p>
                                        </div>

                                        @if (session('lastMovement')->comment)
                                            <div class="md:col-span-2 p-3 rounded-md">
                                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Comentario</p>
                                                <p class="text-base font-semibold text-gray-800 mt-1">
                                                    {{ session('lastMovement')->comment }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="p-4 mt-6 text-green-700 bg-green-100 border border-green-400 rounded-lg">
                            <div class="flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="p-4 mt-6 text-red-700 bg-red-100 border border-red-400 rounded-lg">
                            <div class="flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript vanilla para autofocus permanente -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scanInput = document.getElementById('scanInput');
            const scanForm = document.getElementById('scanForm');

            function focusInput() {
                scanInput.focus();
            }

            focusInput();

            scanForm.addEventListener('submit', function() {
                setTimeout(focusInput, 100);
            });

            document.addEventListener('click', focusInput);

            document.addEventListener('keydown', function(e) {
                if (document.activeElement !== scanInput) {
                    focusInput();
                }
            });
        });
    </script>
</x-app-layout>
