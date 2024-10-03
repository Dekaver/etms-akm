@props(['position', 'tire'])
<style>
</style>
<figure>
    <h4 class="text-center fw-bold">{{ $position }}</h4>
    @if ($tire = $tire->where('position', $position)->pluck('tire')->first())
        <div class="px-3 py-2 border droppableSwitch">
            <div class="draggableUnit position_tire_{{ $position }}"
                style="background-image: url({{ asset('assets/img/tire.png') }});" data-position="{{ $position }}"
                data-id="{{ $tire->id }}" data-km="{{ $tire->lifetime_km }}" data-hm="{{ $tire->lifetime_hm }}"
                data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}" data-rtd="{{ $tire->rtd }}"
                data-serial_number="{{ $tire->serial_number }}" data-tire_id="{{ $tire->id }}"
                data-lifetime="{{ $tire->lifetime }}">
            </div>
            <div class="progress progress-lg">
                <div class="progress-bar" id="tire-image-movement-{{ $position }}" role="progressbar"
                    style="width: {{ round(($tire->rtd / $tire->tire_size->otd) * 100) }}%" aria-valuenow="75"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        <figcaption class="pt-2">
            <p class="mb-0 fw-bold">{{ $tire->serial_number }}</p>
            <p class=" mb-0">
                {{ number_format($tire->lifetime_hm, 0, ',', '.') }} |
                {{ number_format($tire->lifetime_km, 0, ',', '.') }}
            </p>
            <p class="mb-0">
                {{ number_format($tire->lifetime_repair_hm, 0, ',', '.') }} |
                {{ number_format($tire->lifetime_repair_km, 0, ',', '.') }}
            </p>
            <p class="mb-0">{{ $tire->rtd }} | {{ round(($tire->rtd / $tire->tire_size->otd) * 100) }}%</p>
        </figcaption>
    @else
        <div class="droppableInstall" data-position="{{ $position }}">
            NULL
        </div>
        <figcaption class="pt-2">
            <p class=" mb-0 fw-bold">-</p>
            <p class=" mb-0">-</p>
            <p class=" mb-0">-</p>
            <p class=" mb-0">-</p>
        </figcaption>
    @endif
</figure>

@push('js')
    <script>
        tire = @json($tire);
        if (tire != null) {
            position = @json($position);
            // Example: Set the background color based on battery percentage (replace this with your actual battery percentage)
            setDynamicGradientColor(`tire-image-movement-${position}`, parseFloat(tire.rtd / tire.tire_size.otd * 100));
        }
    </script>
@endpush
