@props(['tire'])
<style>
    .container-bar {
        width: 100%;
        height: 100px;
        background-color: #f3f3f3;
        border: 1px solid rgb(83, 83, 83);
        padding: 0px;
        position: relative;
        margin-top: 25px;
        border-radius: 10px;
        overflow: hidden;
        clip-path: inset(0 0 0 0);
    }

    .container-bar .bar {
        width: 100%;
        height: 56%;
        position: absolute;
        bottom: 0;
        z-index: 0;
    }

    .container-bar small {
        position: absolute;
        bottom: 0;
        left: 50%;
        z-index: 3;
        text-align: center;
        color: black;
        font-weight: bold;
        transform: translateX(-50%);
    }

    .container-tooltip .tooltip-tire {
        position:fixed;
        transform: translateX(-50%);
        z-index: 4;
        text-align: left;
        color: black;
        background-color: #f3f3f3;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        pointer-events: none;
        /* To allow clicking through the tooltip */
        width: 200px;
        /* Adjust width as needed */
        padding: 10px;
        /* Add padding for better appearance */
        border-radius: 5px;
    }

    .container-tooltip:hover .tooltip-tire{
        opacity: 0.9;
    }
</style>
<div class="container-tooltip">
    <div class="container-bar" data-tooltip="{{ $tire->serial_number ?? '' }}">
        @if ($tire)
            <small>
                {{ round(($tire->rtd / $tire->tire_size->otd) * 100) }}
            </small>

            <div class="bar" id="tire-image-movement-{{ $tire->id }}"
                style="height: {{ round(($tire->rtd / $tire->tire_size->otd) * 100) }}%" aria-valuenow="75"
                aria-valuemin="0" aria-valuemax="100"></div>
        @else
            <div class="bar" style="width: 0%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
        @endif
    </div>
    @if ($tire)
    <div class="tooltip-tire">
        <p class="mb-0 fw-bold">{{ $tire->serial_number }}</p>
        <p class="mb-0">KM : {{ $tire->lifetime_km }}</p>
        <p class="mb-0">HM : {{ $tire->lifetime_hm }}</p>
        <p class="mb-0">KM After Repair{{ $tire->lifetime_repair_km }}</p>
        <p class="mb-0">HM After Repair{{ $tire->lifetime_repair_hm }}</p>
        <p class="mb-0">RTD : {{ $tire->rtd }}</p>
        <p class="mb-0">Pesen RTD {{ round(($tire->rtd / $tire->tire_size->otd) * 100) }}%</p>
    </div>
    @else
    @endif
</div>


@push('js')
    <script>
        tire = @json($tire);
        if (tire != null) {
            // Example: Set the background color based on battery percentage (replace this with your actual battery percentage)
            setDynamicGradientColor(`tire-image-movement-${tire.id}`, parseFloat(tire.rtd / tire.tire_size.otd * 100));
        }
    </script>
@endpush
