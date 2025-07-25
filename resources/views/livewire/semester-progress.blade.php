{{-- resources/views/livewire/semester-progress.blade.php --}}
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    {{-- Header --}}
    <div class="bg-blue-600 text-white ml-8 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    {{ $title }}
                </h3>
                <p class="text-teal-100 mt-1">
                    Semester {{ $semester }} - {{ $tahun_ajaran }}
                    @if ($id_aspek)
                        @php
                            $selectedAspek = $aspekOptions->where('id_aspek', $id_aspek)->first();
                        @endphp
                        @if ($selectedAspek)
                            - {{ $selectedAspek->kode_aspek }} ({{ $selectedAspek->nama_aspek }})
                        @endif
                    @endif
                </p>
            </div>
            <div class="flex items-center space-x-3">
                {{-- Filter Aspek --}}
                <div class="relative">
                    <select wire:model.live="id_aspek"
                        class="bg-white bg-opacity-20 text-white rounded-lg px-4 py-2 appearance-none pr-8 hover:bg-opacity-30 transition duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50">
                        <option value="">Semua Aspek</option>
                        @foreach ($aspekOptions as $aspek)
                            <option value="{{ $aspek->id_aspek }}">
                                {{ $aspek->kode_aspek }} - {{ $aspek->nama_aspek }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>

                {{-- Tombol Refresh --}}
                <button wire:click="emitChartData"
                    class="px-4 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition duration-200 flex items-center">
                    <i class="fas fa-sync-alt mr-2"></i>
                    <span class="text-sm">Refresh</span>
                </button>

                {{-- Tombol Debug (hapus di production) --}}
                <button wire:click="debugQuery"
                    class="px-4 py-2 bg-red-500 bg-opacity-80 rounded-lg hover:bg-opacity-100 transition duration-200 flex items-center">
                    <i class="fas fa-bug mr-2"></i>
                    <span class="text-sm">Debug</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Aspect Selection Tabs --}}
    <div class="bg-gray-100 px-6 py-3 border-b border-gray-200">
        <div class="flex flex-wrap gap-2">
            <button wire:click="changeSelectedAspek('all')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                {{ $selectedAspek === 'all' ? 'bg-blue-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                <i class="fas fa-layer-group mr-2"></i>
                Semua Aspek
            </button>

            @foreach ($aspekList as $aspek)
                <button wire:click="changeSelectedAspek('{{ $aspek->id_aspek }}')"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                    {{ $selectedAspek == $aspek->id_aspek ? 'bg-blue-600 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-chart-pie mr-2"></i>
                    {{ $aspek->nama_aspek }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Chart Container --}}
    <div class="p-6" wire:ignore>
        <div id="chart-container-{{ $semester }}-{{ $id_aspek }}">
            {!! $chart->container() !!}
        </div>
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading.flex wire:target="emitChartData,id_aspek"
        class="absolute inset-0 bg-white bg-opacity-75 items-center justify-center rounded-2xl">
        <div class="text-center">
            <i class="fas fa-spinner fa-spin text-teal-600 text-2xl mb-2"></i>
            <p class="text-gray-600">Memuat data chart...</p>
        </div>
    </div>
</div>

@push('scripts')
    {{-- Load ApexCharts --}}
    {!! $chart->script() !!}

    <script>
        let currentChart = null;
        let chartContainer = null;

        document.addEventListener('livewire:init', function() {
            initializeChart();

            // Listen for force reload
            Livewire.on('forceChartReload', () => {
                console.log('Force chart reload triggered');
                destroyChart();
                setTimeout(() => {
                    @this.call('emitChartData');
                }, 100);
            });

            // Listen for updates
            Livewire.on('semesterChartUpdated', (event) => {
                const {
                    labels,
                    data,
                    aspek_id,
                    timestamp
                } = event[0];

                console.log('Chart update received:', {
                    labels,
                    data,
                    aspek_id,
                    timestamp
                });

                // Always destroy and recreate chart for clean update
                destroyChart();
                createNewChart(labels, data);
            });

            // Listen for parent refresh
            Livewire.on('refreshChart', () => {
                @this.call('emitChartData');
            });
        });

        function initializeChart() {
            // Initial chart will be created by Larapex
            setTimeout(() => {
                currentChart = document.querySelector('#{{ $chart->id() }}')
                    ?.__apexchart__;
                console.log('Initial chart found:', !!currentChart);
            }, 1000);
        }

        function destroyChart() {
            if (currentChart) {
                try {
                    currentChart.destroy();
                    console.log('Chart destroyed');
                } catch (error) {
                    console.log('Error destroying chart:', error);
                }
                currentChart = null;
            }
        }

        function createNewChart(labels, data) {
            // Find chart container
            const container = document.querySelector('#{{ $chart->id() }}');
            if (!container) {
                console.error('Chart container not found');
                return;
            }

            // Clear container
            container.innerHTML = '';

            // Create new chart options
            const options = {
                series: [{
                    name: 'Rata-rata Skor',
                    data: data
                }],
                chart: {
                    type: 'line',
                    height: 400,
                    animations: {
                        enabled: true,
                        speed: 800
                    }
                },
                colors: ['#0d9488'],
                xaxis: {
                    categories: labels,
                    labels: {
                        rotate: -45,
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Rata-rata Skor'
                    },
                    min: 0,
                    max: 5
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                markers: {
                    colors: ['#0d9488'],
                    strokeWidth: 6,
                    size: 6
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value > 0 ? 'Skor: ' + value.toFixed(2) : 'Belum ada nilai';
                        }
                    }
                },
                grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    }
                }
            };

            // Create new chart
            currentChart = new ApexCharts(container, options);
            currentChart.render().then(() => {
                console.log('New chart created successfully with data:', data);
            }).catch(error => {
                console.error('Error creating chart:', error);
            });
        }
    </script>

    <style>
        /* Responsive chart */
        @media (max-width: 768px) {
            .apexcharts-toolbar {
                display: none !important;
            }
        }

        /* Loading state styling */
        select:disabled {
            opacity: 0.6;
        }

        /* Custom grid styling */
        .grid>div {
            transition: transform 0.2s ease;
        }

        .grid>div:hover {
            transform: translateY(-2px);
        }
    </style>
@endpush
