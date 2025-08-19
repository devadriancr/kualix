<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <form method="POST" action="{{ route('materials.validate') }}" id="scanFormValidate">
                        @csrf

                        <div class="flex items-end gap-4">
                            <div class="flex-1">
                                <x-label for="scanInput" value="{{ 'Escanea etiqueta' }}" class="block text-sm font-medium text-gray-700" />
                                <x-input id="scanInput" name="scanInput" type="text" class="block w-full mt-1" placeholder="Escanea aquí..." autofocus required />
                                <x-input-error for="scanInput" class="mt-2" />
                            </div>

                            <div class="mb-1">
                                <x-button type="submit" class="h-[42px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Validar') }}
                                </x-button>
                            </div>
                        </div>
                    </form>

                    <!-- Mensajes / Resultado -->
                    @if (session('success') && session('material'))
                    @php
                    $material = session('material');
                    $lastMovement = session('lastMovement') ?? null;
                    $isRejected = ($material->status ?? '') === 'rejected' || optional($lastMovement)->type === 'rejection';
                    $isValidated = ($material->status ?? '') === 'validated' || optional($lastMovement)->type === 'validated';
                    @endphp

                    <div class="p-6 mt-6 rounded-lg shadow-sm border-2
                            {{ $isRejected ? 'bg-red-50 border-red-200' : ($isValidated ? 'bg-green-50 border-green-200' : 'bg-white border-gray-200') }}">

                        <h3 class="text-lg font-semibold mb-6 pb-2 border-b
                                {{ $isRejected ? 'text-red-800 border-red-200' : ($isValidated ? 'text-green-800 border-green-200' : 'text-gray-800 border-gray-200') }}">
                            @if($isRejected)
                            <span class="flex items-center gap-2">Material Rechazado</span>
                            @elseif($isValidated)
                            <span class="flex items-center gap-2">Material Validado</span>
                            @else
                            Información del Material
                            @endif
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Tipo -->
                            <div class="rounded-md">
                                <p class="text-xs font-medium uppercase tracking-wider {{ $isRejected ? 'text-red-600' : 'text-gray-500' }}">
                                    Tipo de Movimiento
                                </p>
                                <p class="text-base font-semibold mt-2">
                                    @php
                                    $type = optional($lastMovement)->type ?? 'N/A';
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
                                    <span class="px-3 py-2 rounded-full text-sm font-semibold {{ $colorClasses }}">
                                        {{ $translatedType }}
                                    </span>
                                </p>
                            </div>

                            <!-- Área -->
                            <div class="rounded-md">
                                <p class="text-xs font-medium uppercase tracking-wider {{ $isRejected ? 'text-red-600' : 'text-gray-500' }}">
                                    Área
                                </p>
                                <p class="text-base font-semibold mt-2 {{ $isRejected ? 'text-red-800' : 'text-gray-800' }}">
                                    {{ optional($lastMovement->area)->name ?? 'Sin Área' }}
                                </p>
                            </div>

                            <!-- Comentario -->
                            <div class="rounded-md">
                                <p class="text-xs font-medium uppercase tracking-wider {{ $isRejected ? 'text-red-600' : 'text-gray-500' }}">
                                    Comentario
                                </p>
                                <p class="text-base font-semibold mt-2 {{ $isRejected ? 'text-red-800' : 'text-gray-800' }}">
                                    {{ optional($lastMovement)->comment ?: 'Sin comentarios' }}
                                </p>
                            </div>
                        </div>

                        @if($isRejected)
                        <div class="mt-4 p-3 bg-red-100 border border-red-300 rounded-md">
                            <p class="text-sm text-red-700 font-medium">
                                ⚠️ Este material ha sido rechazado y requiere atención especial.
                            </p>
                        </div>
                        @endif

                    </div>
                    @elseif(session('success') && session('material') && !session('lastMovement'))
                    <div class="p-4 mt-6 text-yellow-700 bg-yellow-100 border border-yellow-400 rounded-lg">
                        <div class="flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <span>Material encontrado pero sin movimientos registrados</span>
                        </div>
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="p-4 mt-6 text-red-700 bg-red-100 border border-red-400 rounded-lg">
                        <div class="flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- JS: autofocus permanente -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scanInput = document.getElementById('scanInput');
            const scanForm = document.getElementById('scanFormValidate');

            function focusInput() {
                if (scanInput) scanInput.focus();
            }

            focusInput();

            if (scanForm) {
                scanForm.addEventListener('submit', function() {
                    setTimeout(focusInput, 100);
                });
            }

            document.addEventListener('click', focusInput);
            document.addEventListener('keydown', function() {
                if (document.activeElement !== scanInput) focusInput();
            });
        });
    </script>
</x-app-layout>
