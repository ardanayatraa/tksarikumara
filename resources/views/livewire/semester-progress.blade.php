{{-- resources/views/livewire/semester-progress.blade.php --}}
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    {{-- Header --}}
    <div class="bg-blue-600 text-white ml-8 p-6 flex items-center justify-between">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>
                    {{ $title }}
                </h3>
                <p class="text-teal-100 mt-1">
                    Semester {{ $semester }} - {{ $tahun_ajaran }}
                </p>
            </div>
            <div class="flex items-center">
                {{-- Tombol Refresh --}}
                <button wire:click="emitChartData"
                    class="px-4 py-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition duration-200 flex items-center">
                    <i class="fas fa-sync-alt mr-2"></i>
                    <span class="text-sm">Refresh</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Chart Container --}}
    <div class="p-6" wire:ignore>
        {!! $chart->container() !!}
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading.flex wire:target="emitChartData"
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
        document.addEventListener('livewire:init', function() {
            // Store chart instance
            setTimeout(() => {
                window.semesterChart = document.querySelector('#{{ $chart->id() }}')
                    .__apexchart__;
            }, 500);

            // Listen for updates
            Livewire.on('semesterChartUpdated', (event) => {
                const {
                    labels,
                    data
                } = event[0];

                if (window.semesterChart) {
                    // Update chart
                    window.semesterChart.updateOptions({
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
                        tooltip: {
                            y: {
                                formatter: function(value) {
                                    return value > 0 ? 'Skor: ' + value.toFixed(2) :
                                        'Belum ada nilai';
                                }
                            }
                        }
                    });

                    window.semesterChart.updateSeries([{
                        name: 'Rata-rata Skor',
                        data: data
                    }]);
                }
            });

            // Listen for parent refresh
            Livewire.on('refreshChart', () => {
                @this.call('emitChartData');
            });
        });
    </script>

    <style>
        /* Responsive chart */
        @media (max-width: 768px) {
            .apexcharts-toolbar {
                display: none !important;
            }
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
