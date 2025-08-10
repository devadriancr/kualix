<x-app-layout>

    @php
        $statusMap = [
            'pending'  => 'Pendiente',
            'approved' => 'Aprobado',
            'rejected' => 'Rechazado',
            null       => 'Sin estado'
        ];

        $typeMap = [
            'entry'      => 'Entrada',
            'exit'       => 'Salida',
            'inspection' => 'Inspección',
            'rejection'  => 'Rechazo',
            'validated'  => 'Validado'
        ];

        // Etiquetas y keys de estatus (para asignar colores)
        $statusKeys = array_keys($statusCounts);
        $statusLabelsSpanish = [];
        foreach ($statusKeys as $k) {
            $statusLabelsSpanish[] = $statusMap[$k] ?? 'Sin estado';
        }
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Estadísticas</h3>
                    <p class="text-sm text-gray-500">Resumen rápido de materiales y movimientos</p>
                </div>

                <!-- Selector de periodo (más grande y visible) -->
                <form method="GET" class="flex items-center space-x-3">
                    <label class="text-sm text-gray-600 dark:text-gray-300">Periodo:</label>
                    <select name="days"
                            onchange="this.form.submit()"
                            class="w-44 md:w-56 px-4 py-2 text-sm md:text-base rounded-lg border border-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach($daysOptions as $opt)
                            <option value="{{ $opt }}" @if($opt == $days) selected @endif>{{ $opt }} días</option>
                        @endforeach
                    </select>
                    <noscript>
                        <button type="submit" class="px-3 py-2 bg-indigo-600 text-white rounded">Aplicar</button>
                    </noscript>
                </form>
            </div>

            <!-- Resumen cards (ahora 3 columnas en lg) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border">
                    <p class="text-xs text-gray-500">Total de materiales</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mt-2">{{ $totalMaterials }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border">
                    <p class="text-xs text-gray-500">Estatus</p>
                    <div class="mt-2">
                        @forelse($statusCounts as $status => $count)
                            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-200 py-0.5">
                                <span>{{ $statusMap[$status] ?? 'Sin estado' }}</span>
                                <span class="font-medium">{{ $count }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Sin datos</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border">
                    <p class="text-xs text-gray-500">Movimientos por área</p>
                    <div class="mt-2">
                        @forelse($movementsByArea as $area => $count)
                            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-200 py-0.5">
                                <span>{{ $area }}</span>
                                <span class="font-medium">{{ $count }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Sin datos</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Gráficas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border">
                    <h4 class="text-lg font-medium mb-3 text-gray-800 dark:text-gray-100">Estatus de materiales</h4>
                    <div class="chart-card h-56 md:h-64">
                        <canvas id="statusChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border">
                    <h4 class="text-lg font-medium mb-3 text-gray-800 dark:text-gray-100">Materiales creados (últimos {{ $days }} días)</h4>
                    <div class="chart-card h-56 md:h-64">
                        <canvas id="materialsPerDayChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border lg:col-span-2">
                    <h4 class="text-lg font-medium mb-3 text-gray-800 dark:text-gray-100">Movimientos por área</h4>
                    <div class="chart-card h-56 md:h-72">
                        <canvas id="movementsByAreaChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Movimientos recientes -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border">
                <h4 class="text-lg font-medium mb-4 text-gray-800 dark:text-gray-100">Movimientos recientes</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr class="text-left text-gray-500">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Material</th>
                                <th class="px-4 py-2">Área</th>
                                <th class="px-4 py-2">Usuario</th>
                                <th class="px-4 py-2">Tipo</th>
                                <th class="px-4 py-2">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentMovements as $m)
                                <tr class="text-gray-700 dark:text-gray-200">
                                    <td class="px-4 py-2">{{ $m->id }}</td>
                                    <td class="px-4 py-2">{{ optional($m->material)->order_number ?? optional($m->material)->ulid ?? '—' }}</td>
                                    <td class="px-4 py-2">{{ optional($m->area)->name ?? '—' }}</td>
                                    <td class="px-4 py-2">{{ optional($m->user)->name ?? '—' }}</td>
                                    <td class="px-4 py-2">{{ $typeMap[$m->type] ?? $m->type }}</td>
                                    <td class="px-4 py-2">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <style>
        .chart-card canvas { width: 100% !important; height: 100% !important; display: block; }
    </style>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Datos desde el controlador
        const statusKeys = @json($statusKeys); // ej. ['pending','approved','rejected']
        const statusLabels = @json($statusLabelsSpanish); // etiquetas en español
        const statusCounts = @json(array_values($statusCounts));

        const materialsPerDayLabels = @json($materialsPerDayLabels);
        const materialsPerDayValues = @json($materialsPerDayValues);

        const movementsByAreaLabels = @json(array_keys($movementsByArea));
        const movementsByAreaValues = @json(array_values($movementsByArea));

        // Colores base que pediste para líneas/barras
        const BG_COLOR = 'rgba(75, 192, 192, 0.2)';
        const BORDER_COLOR = 'rgb(75, 192, 192)';

        // Colores por estatus (bg con alpha y borde sólido)
        const STATUS_BG = {
            'pending': 'rgba(255, 205, 86, 0.6)',   // amarillo
            'approved': 'rgba(75, 192, 192, 0.6)',  // verde/teal
            'rejected': 'rgba(255, 99, 132, 0.6)',  // rojo
            'null': 'rgba(201,203,207,0.6)'         // gris (sin estado)
        };
        const STATUS_BORDER = {
            'pending': 'rgb(255, 205, 86)',
            'approved': 'rgb(75, 192, 192)',
            'rejected': 'rgb(255, 99, 132)',
            'null': 'rgb(201,203,207)'
        };

        // Construir arrays de color para el donut según los keys (si no encuentra key usa 'null')
        const statusBgArray = statusKeys.map(k => STATUS_BG[k] ?? STATUS_BG['null']);
        const statusBorderArray = statusKeys.map(k => STATUS_BORDER[k] ?? STATUS_BORDER['null']);

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, padding: 10 } },
                tooltip: { mode: 'index', intersect: false }
            },
            interaction: { mode: 'nearest', axis: 'x', intersect: false }
        };

        // Donut - estatus (colores por estatus)
        new Chart(document.getElementById('statusChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusCounts,
                    backgroundColor: statusBgArray,
                    borderColor: statusBorderArray,
                    borderWidth: 1
                }]
            },
            options: Object.assign({}, commonOptions, { cutout: '50%' })
        });

        // Línea - materiales por día (usa EXACTAMENTE los colores que pediste)
        new Chart(document.getElementById('materialsPerDayChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: materialsPerDayLabels,
                datasets: [{
                    label: 'Materiales',
                    data: materialsPerDayValues,
                    fill: true,
                    backgroundColor: BG_COLOR,
                    borderColor: BORDER_COLOR,
                    tension: 0.2,
                    pointRadius: 3,
                    borderWidth: 2
                }]
            },
            options: Object.assign({}, commonOptions, {
                scales: {
                    x: { display: true, ticks: { maxRotation: 0, autoSkip: true } },
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            })
        });

        // Barras - movimientos por área (usa color base)
        new Chart(document.getElementById('movementsByAreaChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: movementsByAreaLabels,
                datasets: [{
                    label: 'Movimientos',
                    data: movementsByAreaValues,
                    backgroundColor: movementsByAreaValues.map(() => 'rgba(75, 192, 192, 0.6)'),
                    borderColor: movementsByAreaValues.map(() => 'rgb(75, 192, 192)'),
                    borderWidth: 0
                }]
            },
            options: Object.assign({}, commonOptions, {
                scales: {
                    x: {
                        display: true,
                        ticks: { autoSkip: false, maxRotation: 45, minRotation: 0 }
                    },
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                },
                datasets: { bar: { maxBarThickness: 44, borderRadius: 6 } }
            })
        });
    </script>
</x-app-layout>
