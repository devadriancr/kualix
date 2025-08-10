<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <form method="POST" action="{{ route('materials.store') }}" id="scanForm">
                        @csrf

                        <div class="flex items-end gap-4">
                            <!-- Input con autofocus -->
                            <div class="flex-1">
                                <x-label for="scanInput" value="{{ 'Escanea etiqueta' }}"
                                    class="block text-sm font-medium text-gray-700" />
                                <x-input id="scanInput" name="scanInput" type="text" class="block w-full mt-1"
                                    placeholder="Escanea aquí..." autofocus required />
                                <x-input-error for="scanInput" class="mt-2" />
                            </div>

                            <!-- Botón al lado del input -->
                            <div class="mb-1">
                                <x-button type="submit" class="h-[42px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Guardar') }}
                                </x-button>
                            </div>
                        </div>
                    </form>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scanInput = document.getElementById('scanInput');
            const scanForm = document.getElementById('scanForm');

            // Función para enfocar el input
            function focusInput() {
                scanInput.focus();
            }

            // Enfocar al cargar la página
            focusInput();

            // Enfocar después de enviar el formulario
            scanForm.addEventListener('submit', function() {
                setTimeout(focusInput, 100);
            });

            // Enfocar al hacer clic en cualquier parte del documento
            document.addEventListener('click', focusInput);

            // Enfocar cuando se presiona cualquier tecla (excepto dentro del input)
            document.addEventListener('keydown', function(e) {
                if (document.activeElement !== scanInput) {
                    focusInput();
                }
            });
        });
    </script>
</x-app-layout>
