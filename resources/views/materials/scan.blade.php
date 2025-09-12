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
                                <x-button type="submit" id="submitButton" class="h-[42px]">
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
            const submitButton = document.getElementById('submitButton');
            let isSubmitting = false;

            // Función para enfocar el input
            function focusInput() {
                // Solo enfocar si no estamos en proceso de envío
                if (!isSubmitting) {
                    scanInput.focus();
                }
            }

            // Enfocar al cargar la página
            focusInput();

            // Prevenir envíos múltiples
            scanForm.addEventListener('submit', function(e) {
                if (isSubmitting) {
                    e.preventDefault();
                    return;
                }

                isSubmitting = true;

                // Deshabilitar el botón y cambiar texto
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ __('Procesando...') }}
                `;

                // Re-enfocar después de que se complete el envío
                // Usamos un timeout más largo para asegurar que el envío termine
                setTimeout(function() {
                    isSubmitting = false;
                    submitButton.disabled = false;
                    submitButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ __('Guardar') }}
                    `;
                    focusInput();
                    scanInput.value = ''; // Limpiar el input
                }, 2000); // 2 segundos deberían ser suficientes
            });

            // Enfocar cuando se presiona cualquier tecla (excepto dentro del input)
            document.addEventListener('keydown', function(e) {
                // No enfocar si es Tab, Shift, Ctrl, Alt, etc.
                if (e.key.length === 1 && document.activeElement !== scanInput &&
                    !isSubmitting && !e.ctrlKey && !e.altKey && !e.metaKey) {
                    focusInput();
                }
            });

            // Enfocar al hacer clic en cualquier parte del documento (excepto en botones y enlaces)
            document.addEventListener('click', function(e) {
                if (!isSubmitting &&
                    !e.target.closest('button') &&
                    !e.target.closest('a') &&
                    e.target !== scanInput) {
                    focusInput();
                }
            });

            // También enfocar cuando la ventana gana foco
            window.addEventListener('focus', focusInput);
        });
    </script>
</x-app-layout>
