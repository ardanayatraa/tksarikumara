<div wire:ignore>
    <h3 class="text-xl font-semibold mb-4">{{ $title }}</h3>
    {!! $chart->container() !!}
</div>

@push('scripts')
    {{-- ini akan mem-load apexcharts dan inisialisasi awal --}}
    {!! $chart->script() !!}

    <script>
        document.addEventListener('livewire:load', function() {
            // ApexCharts instance disimpan di window mingguChart
            window.weeklyChart = document.querySelector('#{{ $chart->id() }}')
                .__apexchart__; // Larapex menyimpan instance di element.__apexchart__

            // Dengarkan browser event chartDataUpdated
            window.addEventListener('chartDataUpdated', event => {
                const {
                    labels,
                    data
                } = event.detail;
                // update kategori X
                weeklyChart.updateOptions({
                    xaxis: {
                        categories: labels
                    }
                });
                // update data series
                weeklyChart.updateSeries([{
                    name: 'Skor',
                    data: data
                }]);
            });

            // Opsional: juga dengarkan event Livewire 'refreshDatatable'
            Livewire.on('refreshDatatable', () => {
                Livewire.emit('refreshChart');
            });
        });
    </script>
@endpush
