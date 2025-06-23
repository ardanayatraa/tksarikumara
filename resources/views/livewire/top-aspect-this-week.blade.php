<div wire:ignore>
    <h3 class="text-xl font-semibold mb-4">{{ $title }}</h3>
    {!! $chart->container() !!}
</div>

@push('scripts')
    {!! $chart->script() !!}
@endpush
