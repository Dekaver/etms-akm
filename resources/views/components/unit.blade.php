@props(['unit'])
@php
    $tire_running = $unit->tire_runnings;
    $unit_model = $unit->unit_model;
@endphp
<style>
    .col {
        padding: 0;
    }

    .unit-view {
        border: 1px rgb(105, 105, 105) solid
    }

    .unit-view .col .axle {
        width: 100%;
        height: 10px;
        background: #000;
    }

    .unit-view .unit-tires {
        position: relative;
    }

    .unit-view .unit-tires .axle-y {
        position: absolute;
        left: 50%;
        transform: translate(-50%, -50%);
        top: 50%;
        width: 10px;
        height: 70%;
        background: #000;
    }
</style>
<div class="col-12 col-md-3 unit-view p-3">
    <div class="row">
        <div class="col-6 unit-tires">
            <div class="axle-y"></div>
            @php
                $position = 0;
            @endphp
            @for ($i = 0; $i < $unit_model->axle_2_tire; $i++)
                <div class="row justify-content-center align-items-center mb-2">
                    <div class="col"></div>
                    <div class="col">
                        @php $position += 1 @endphp
                        <x-tire-rtd :tire="$tire_running
                            ->where('position', $position)
                            ->pluck('tire')
                            ->first()" />
                    </div>
                    <div class="col">
                        <div class="axle"></div>
                    </div>
                    <div class="col">
                        @php $position += 1 @endphp
                        <x-tire-rtd :tire="$tire_running
                            ->where('position', $position)
                            ->pluck('tire')
                            ->first()" />
                    </div>
                    <div class="col"></div>
                </div>
            @endfor

            @for ($i = 0; $i < $unit_model->axle_4_tire; $i++)
                <div class="row justify-content-center align-items-center mb-2">
                    <div class="col">
                        @php $position += 1 @endphp
                        <x-tire-rtd :tire="$tire_running
                            ->where('position', $position)
                            ->pluck('tire')
                            ->first()" />
                    </div>
                    <div class="col">
                        @php $position += 1 @endphp
                        <x-tire-rtd :tire="$tire_running
                            ->where('position', $position)
                            ->pluck('tire')
                            ->first()" />
                    </div>
                    <div class="col">
                        <div class="axle"></div>

                    </div>
                    <div class="col">
                        @php $position += 1 @endphp
                        <x-tire-rtd :tire="$tire_running
                            ->where('position', $position)
                            ->pluck('tire')
                            ->first()" />
                    </div>
                    <div class="col">
                        @php $position += 1 @endphp
                        <x-tire-rtd :tire="$tire_running
                            ->where('position', $position)
                            ->pluck('tire')
                            ->first()" />
                    </div>
                </div>
            @endfor

        </div>
        <div class="col-6">
            <h5 class="float-end">{{ $unit->unit_number }}</h5>
            <br>
            <hr>
            <p>KM : <small class="float-end">{{ $unit->km }}</small></p>
            <p>HM : <small class="float-end">{{ $unit->hm }}</small></p>
            <p>Total Inspection : <small class="float-end">{{ $unit->daily_inspect->count() }}</small></p>
            <p>Last Inpection : <small class="float-end">{{ $unit->inspection_last_update }}</small></p>
            <p style="font-weight: bold !important">Last Replacement : <small class="float-end">{{ $unit->replace_last_update }}</small></p>
        </div>
    </div>
</div>
