{{-- resources/views/livewire/top-aspect-this-week-modal.blade.php --}}
<div class="bg-white rounded-lg overflow-hidden">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold">Top Aspek Minggu Ini</h3>
                <p class="text-green-100 text-sm">
                    {{ \Carbon\Carbon::parse($startDate)->format('d M') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                </p>
            </div>
            <div class="text-right">
                @if ($hasData)
                    <div class="text-xl font-bold">{{ $avgOverall }}</div>
                    <div class="text-green-100 text-xs">Rata-rata</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Chart Container --}}
    <div class="p-4 relative" wire:ignore>
        @if ($hasData)
            <div id="chart-modal-top-aspect" class="min-h-[350px]">
                {!! $chart->container() !!}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8 text-center min-h-[350px]">
                <i class="fas fa-chart-line text-gray-300 text-4xl mb-3"></i>
                <h4 class="text-base font-medium text-gray-700 mb-1">Belum Ada Data</h4>
                <p class="text-gray-500 text-sm">Tidak ada penilaian minggu ini</p>
            </div>
        @endif

        {{-- Loading Overlay --}}
        <div wire:loading.flex wire:target="refreshData"
            class="absolute inset-0 bg-white bg-opacity-90 items-center justify-center rounded-lg">
            <div class="text-center">
                <i class="fas fa-spinner fa-spin text-green-600 text-2xl mb-2"></i>
                <p class="text-gray-600 text-sm">Memuat data...</p>
            </div>
        </div>
    </div>

    {{-- Minimal Horizontal Summary --}}
    @if ($hasData && !empty($detailData))
        <div class="px-4 pb-2">
            <div class="bg-white border border-gray-200 rounded-md p-2 flex items-center justify-between text-sm">
                <div class="text-center px-2">
                    <div class="text-base font-semibold text-green-600">{{ $topScore }}</div>
                    <div class="text-gray-500 text-[11px]">Tertinggi</div>
                </div>
                <div class="text-center px-2">
                    <div class="text-base font-semibold text-blue-600">{{ $avgOverall }}</div>
                    <div class="text-gray-500 text-[11px]">Rata-rata</div>
                </div>
                <div class="text-center px-2">
                    <div class="text-base font-semibold text-purple-600">{{ $totalAspek }}</div>
                    <div class="text-gray-500 text-[11px]">Aspek</div>
                </div>
            </div>
        </div>
    @endif


    {{-- Footer dengan Legend --}}
    <div class="bg-gray-50 px-4 py-3 border-t">
        <div class="flex items-center justify-center space-x-4 text-xs">
            <div class="flex items-center">
                <div class="w-2 h-2 bg-green-500 rounded-full mr-1"></div>
                <span class="text-gray-600">Sangat Baik</span>
            </div>
            <div class="flex items-center">
                <div class="w-2 h-2 bg-blue-500 rounded-full mr-1"></div>
                <span class="text-gray-600">Baik</span>
            </div>
            <div class="flex items-center">
                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-1"></div>
                <span class="text-gray-600">Cukup</span>
            </div>
            <div class="flex items-center">
                <div class="w-2 h-2 bg-red-500 rounded-full mr-1"></div>
                <span class="text-gray-600">Perlu Perhatian</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @if ($hasData)
        {!! $chart->script() !!}

        <script>
            // Customize line chart for modal
            document.addEventListener('livewire:init', function() {
                setTimeout(() => {
                    const chartElement = document.querySelector('#{{ $chart->id() }}');
                    if (chartElement && chartElement.__apexchart__) {
                        const chart = chartElement.__apexchart__;

                        // Update chart options for modal line chart
                        chart.updateOptions({
                            chart: {
                                height: 350,
                                toolbar: {
                                    show: false
                                }
                            },
                            title: {
                                text: '',
                                style: {
                                    fontSize: '0px'
                                } // Hide title completely
                            },
                            legend: {
                                show: false // Hide legend
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '11px'
                                    },
                                    rotate: -45
                                },
                                title: {
                                    text: ''
                                } // No axis title
                            },
                            yaxis: {
                                labels: {
                                    style: {
                                        fontSize: '11px'
                                    }
                                },
                                title: {
                                    text: ''
                                } // No axis title
                            },
                            dataLabels: {
                                enabled: true,
                                style: {
                                    fontSize: '10px',
                                    fontWeight: 'bold'
                                },
                                background: {
                                    enabled: true,
                                    foreColor: '#fff',
                                    borderRadius: 2,
                                    padding: 2
                                }
                            },
                            stroke: {
                                width: 3,
                                curve: 'smooth'
                            },
                            markers: {
                                size: 5
                            },
                            tooltip: {
                                y: {
                                    formatter: function(value) {
                                        return value.toFixed(2);
                                    }
                                }
                            }
                        });
                    }
                }, 1000);
            });
        </script>
    @endif

    <style>
        .min-h-[350px] {
            min-height: 350px;
        }

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
    </style>
@endpush
