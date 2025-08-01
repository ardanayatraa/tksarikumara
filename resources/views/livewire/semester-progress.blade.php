{{-- resources/views/livewire/semester-progress-modal.blade.php --}}
<div class="bg-white rounded-lg overflow-hidden">
    {{-- Header dengan Filter --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-3 lg:space-y-0">
            <div>
                <h3 class="text-lg font-semibold">
                    Progress Semester {{ $semester }} - {{ $tahun_ajaran }}
                </h3>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                {{-- Filter Aspek --}}
                <div class="relative">
                    <select wire:model.live="id_aspek"
                        class="bg-white bg-opacity-20 text-white rounded-lg px-3 py-2 text-sm appearance-none pr-8 hover:bg-opacity-30 transition duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 backdrop-blur-sm min-w-[150px]">
                        <option value="" style="color: #374151;">Semua Aspek</option>
                        @foreach ($aspekOptions as $aspek)
                            <option value="{{ $aspek->id_aspek }}" style="color: #374151;">
                                {{ $aspek->kode_aspek }} - {{ Str::limit($aspek->nama_aspek, 20) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>

                {{-- Filter Kelompok Usia --}}
                <div class="relative">
                    <select wire:model.live="kelompok_usia"
                        class="bg-white bg-opacity-20 text-white rounded-lg px-3 py-2 text-sm appearance-none pr-8 hover:bg-opacity-30 transition duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 backdrop-blur-sm min-w-[120px]">
                        <option value="" style="color: #374151;">Semua Usia</option>
                        @foreach ($kelompokUsiaOptions as $key => $label)
                            <option value="{{ $key }}" style="color: #374151;">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>

                {{-- Tombol Refresh --}}
                <button wire:click="emitChartData"
                    class="px-3 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition duration-200 flex items-center backdrop-blur-sm">
                    <i class="fas fa-sync-alt text-sm"></i>
                </button>
            </div>
        </div>

        {{-- Info Filter Aktif --}}
        @if ($id_aspek || $kelompok_usia)
            <div class="mt-3 flex flex-wrap gap-2">
                @if ($id_aspek)
                    @php
                        $selectedAspek = $aspekOptions->where('id_aspek', $id_aspek)->first();
                    @endphp
                    @if ($selectedAspek)
                        <span class="bg-white bg-opacity-20 px-2 py-1 rounded-md text-xs">
                            {{ $selectedAspek->kode_aspek }} - {{ $selectedAspek->nama_aspek }}
                        </span>
                    @endif
                @endif
                @if ($kelompok_usia)
                    <span class="bg-purple-500 bg-opacity-80 px-2 py-1 rounded-md text-xs">
                        {{ $kelompokUsiaOptions[$kelompok_usia] }}
                    </span>
                @endif
            </div>
        @endif
    </div>

    {{-- Chart Container --}}
    <div class="p-4 relative" wire:ignore>
        <div id="chart-container-modal-{{ $semester }}-{{ $id_aspek }}-{{ $kelompok_usia }}"
            class="min-h-[350px]">
            {!! $chart->container() !!}
        </div>

        {{-- Loading Overlay --}}
        <div wire:loading.flex wire:target="emitChartData,id_aspek,kelompok_usia"
            class="absolute inset-0 bg-white bg-opacity-90 items-center justify-center rounded-lg">
            <div class="text-center">
                <i class="fas fa-spinner fa-spin text-blue-600 text-2xl mb-2"></i>
                <p class="text-gray-600 text-sm">Memuat data...</p>
            </div>
        </div>
    </div>

    {{-- Simple Stats Footer --}}
    <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
        <div class="flex justify-between items-center text-sm">
            <div class="flex items-center space-x-4 text-gray-600">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-1"></div>
                    <span>Rata-rata: {{ $stats['rata_rata'] }}</span>
                </div>
                <div>Progress: {{ $stats['progress_percent'] }}%</div>
            </div>
            <div class="text-gray-500">
                {{ $stats['minggu_dinilai'] }}/20 minggu dinilai
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {!! $chart->script() !!}

    <script>
        let modalChart = null;
        let isModalUpdating = false;

        document.addEventListener('livewire:init', function() {
            initializeModalChart();

            Livewire.on('forceChartReload', () => {
                if (isModalUpdating) return;

                console.log('Modal chart reload triggered');
                isModalUpdating = true;
                destroyModalChart();

                setTimeout(() => {
                    @this.call('emitChartData').then(() => {
                        isModalUpdating = false;
                    });
                }, 200);
            });

            Livewire.on('semesterChartUpdated', (event) => {
                if (isModalUpdating) return;

                const {
                    labels,
                    data
                } = event[0];

                isModalUpdating = true;
                destroyModalChart();

                setTimeout(() => {
                    createModalChart(labels, data);
                    isModalUpdating = false;
                }, 100);
            });
        });

        function initializeModalChart() {
            setTimeout(() => {
                const chartElement = document.querySelector('#{{ $chart->id() }}');
                if (chartElement && chartElement.__apexchart__) {
                    modalChart = chartElement.__apexchart__;
                    console.log('Modal chart initialized');
                }
            }, 1000);
        }

        function destroyModalChart() {
            if (modalChart) {
                try {
                    modalChart.destroy();
                } catch (error) {
                    console.log('Error destroying modal chart:', error);
                }
                modalChart = null;
            }
        }

        function createModalChart(labels, data) {
            const container = document.querySelector('#{{ $chart->id() }}');
            if (!container) return;

            container.innerHTML = '';
            const validData = data.map(d => d || 0);
            const hasData = validData.some(d => d > 0);

            const options = {
                series: [{
                    name: 'Rata-rata Skor',
                    data: validData
                }],
                chart: {
                    type: 'line',
                    height: 350,
                    animations: {
                        enabled: true,
                        speed: 600
                    },
                    toolbar: {
                        show: false
                    } // Hide toolbar for modal
                },
                colors: ['#3b82f6'],
                xaxis: {
                    categories: labels,
                    labels: {
                        rotate: -45,
                        style: {
                            fontSize: '11px'
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 4,
                    labels: {
                        formatter: function(value) {
                            return value.toFixed(1);
                        }
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                markers: {
                    size: 4,
                    colors: ['#3b82f6'],
                    strokeWidth: 2,
                    strokeColors: '#fff'
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            if (value > 0) {
                                return 'Skor: ' + value.toFixed(2);
                            }
                            return 'Belum ada penilaian';
                        }
                    }
                },
                grid: {
                    borderColor: '#e5e7eb',
                    strokeDashArray: 3
                },
                dataLabels: {
                    enabled: false
                },
                annotations: !hasData ? {
                    texts: [{
                        x: '50%',
                        y: '50%',
                        text: 'Tidak ada data',
                        textAnchor: 'middle',
                        style: {
                            fontSize: '14px',
                            color: '#6b7280'
                        }
                    }]
                } : {}
            };

            modalChart = new ApexCharts(container, options);
            modalChart.render();
        }
    </script>

    <style>
        /* Modal specific styles */
        .min-h-[350px] {
            min-height: 350px;
        }

        /* Compact select styling */
        select {
            font-size: 13px;
        }

        select option {
            background-color: white;
            color: #374151;
            padding: 4px;
        }

        /* Loading animation */
        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive adjustments for modal */
        @media (max-width: 640px) {
            .min-w-[150px] {
                min-width: 120px;
            }

            .min-w-[120px] {
                min-width: 100px;
            }
        }
    </style>
@endpush
