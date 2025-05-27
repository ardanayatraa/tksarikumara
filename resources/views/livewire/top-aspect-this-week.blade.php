<div wire:ignore>
    <h3 class="text-xl font-semibold mb-4">{{ $title }}</h3>
    {{-- ini akan merender <div id="apexchart-..."></div> --}}
    {!! $chart->container() !!}
</div>

@push('scripts')
    {{-- ini memuat <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> sekali, plus init chart --}}
    {!! $chart->script() !!}
@endpush
