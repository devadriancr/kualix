<x-app-layout>
    <div class="max-w-xl mx-auto mt-12 bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Inspección de material</h2>

        <div class="mb-4">
            <p><strong>Código escaneado:</strong> {{ $material->barcode }}</p>
            <p><strong>Orden:</strong> {{ $material->order_number }}</p>
            <p><strong>Secuencia:</strong> {{ $material->sequence }}</p>
        </div>

        <form method="POST" action="{{ route('materials.storeInspection', $material) }}">
            @csrf

            <div class="mb-4">
                <x-label for="status" value="Resultado de inspección" />
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded">
                    <option value="good">✅ Bueno</option>
                    <option value="bad">❌ Malo</option>
                </select>
                <x-input-error for="status" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-label for="comment" value="Comentario (si es malo)" />
                <textarea name="comment" id="comment" rows="3" class="mt-1 block w-full border-gray-300 rounded"></textarea>
                <x-input-error for="comment" class="mt-2" />
            </div>

            <x-button class="w-full justify-center">
                Guardar resultado
            </x-button>
        </form>
    </div>
</x-app-layout>
