@props(['position', 'tire'])

<figure>
    <h4 class="text-center fw-bold">{{ $position }}</h4>
    @if ($tire = $tire->where('position', $position)->pluck('tire')->first())
        <div
            class="bg-secondary bg-opacity-10 px-3 py-2 border border-grey droppableSwitch">
            <div class="draggableUnit position_tire_{{ $position }}"
                style="background-image: url({{ asset('assets/img/tire.png') }});"
                data-position="{{ $position }}" data-id="{{ $tire->id }}"
                data-km="{{ $tire->lifetime_km }}"
                data-hm="{{ $tire->lifetime_hm }}"
                data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                data-rtd="{{ $tire->rtd }}"
                data-serial_number="{{ $tire->serial_number }}"
                data-tire_id="{{ $tire->id }}"
                data-lifetime="{{ $tire->lifetime }}">
            </div>
        </div>
        <figcaption class="pt-2">
            <p class="mb-0 fw-bold">{{ $tire->serial_number }}</p>
            <p class=" mb-0">{{ $tire->lifetime_hm }} / {{ $tire->lifetime_km }}</p>
            <p class="mb-0">{{ $tire->lifetime_repair_hm }} / {{ $tire->lifetime_repair_km }}</p>
            <p class="mb-0">{{ $tire->rtd }}</p>
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
