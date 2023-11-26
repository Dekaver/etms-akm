<x-app-layout>

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/scrollable.css') }}">
        <style>
            .invalid-data {
                border: 1px solid red;
            }

            .draggable,
            .draggableUnit {
                /* width: 90px; */
                background-repeat: no-repeat;
                background-size: contain;
                background-position-x: center;
                height: 137px;
                z-index: 2;
            }

            .tire {
                width: 110px;
                background-repeat: no-repeat;
                background-size: contain;
                height: 110px;
            }

            .draggableInventory {
                width: 90px;
                background-repeat: no-repeat;
                background-size: contain;
                background-position-x: center;
                height: 137px;
                z-index: 2;
            }

            .axle {
                width: 110px;
                background-repeat: no-repeat;
                background-size: contain;
                height: 110px;
            }

            .card.droppable .card-body {
                padding: 0px;
                text-align: center;
            }

            .droppable,
            .droppableInstall {
                display: flex;
                width: 90px;
                align-items: center;
                justify-content: center;
                border-radius: 5%;
                height: 150px;
                border: 1px black solid;
            }

            /* .droppableSwitch {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    display: flex;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    width: 90px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    align-items: center;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    justify-content: center;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    border-radius: 5%;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    height: 150px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    border: 1px black solid;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                } */

            .form-group {
                margin-bottom: 10px;
            }

            .form-group label {
                margin-bottom: 0px;
            }
        </style>
    @endpush

    <div class="page-header">
        <div class="page-title">
            <h4>Tire Movement</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Movement</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card ">
        <div class="card-body">
            <h5 class="mb-3" id="widget">Tire Movement Update</h5>
            <div class="row d-sm-none">
                <div class="mb-2 col-6 col-sm-4 col-md col-lg">
                    <p class="mb-0 text-secondary">ID</p>
                    <p class="fs-6 fw-bold">{{ $unit->unit_number }}</p>
                </div>
                <div class="mb-2 col-6 col-sm-4 col-md col-lg">
                    <p class="mb-0 text-secondary">MODEL</p>
                    <p class="fs-6 fw-bold">{{ $unit->unit_model->model ?? '' }}</p>
                </div>
                <div class="mb-2 col-6 col-sm-4 col-md col-lg">
                    <p class="mb-0 text-secondary">KM</p>
                    <p class="fs-6 fw-bold">{{ $unit->km }}</p>
                </div>
                <div class="mb-2 col-6 col-sm-4 col-md col-lg">
                    <p class="mb-0 text-secondary">HM</p>
                    <p class="fs-6 fw-bold">{{ $unit->hm }}</p>
                </div>
                <div class="mb-2 col-6 col-sm-4 col-md col-lg">
                    <p class="mb-0 text-secondary">Tire Size</p>
                    <p class="fs-6 fw-bold">{{ $unit->unit_model->tire_size->size ?? '' }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table>
                        <tr>
                            <td>ID</td>
                            <td class="px-4">: </td>
                            <td>{{ $unit->unit_number }}</td>
                            <td></td>
                            <td class="px-4">MODEL</td>
                            <td class="px-4">: </td>
                            <td>{{ $unit->unit_model->model ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>HM</td>
                            <td class="px-4">: </td>
                            <td>{{ $unit->hm }}</td>
                            <td></td>
                            <td class="px-4">KM</td>
                            <td class="px-4">: </td>
                            <td>{{ $unit->km }}</td>
                        </tr>
                        <tr>
                            <td>TIRE SIZE</td>
                            <td class="">: </td>
                            <td>{{ $unit->unit_model->tire_size->size ?? '' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- MOBILE --}}
    <div class="card d-xxl-none page-body">
        @php
            $position = 0;
        @endphp
        <div class="card-body px-3 py-4">
            <div class="row justify-content-center">
                @for ($i = 0; $i < $unit_model->tire_qty; $i++)
                    <div class="col-12 col-sm-7 col-md-6 col-lg-6 col-xl-4">
                        <div class="row mb-4 justify-content-center">
                            @php
                                $position += 1;
                            @endphp
                            @if ($tire = $tire_running->where('position', $position)->pluck('tire')->first())
                                <div class="col-3 bg-secondary bg-opacity-10 px-3 py-2 border border-grey">
                                    <img class="w-100" src="{{ asset('assets/img/tire.png') }}" alt="">
                                </div>
                                <div class="col-8">
                                    <p class="fw-bold text-primary fs-6 mb-0">POSISI {{ $position }}</p>
                                    <div class="d-flex">
                                        <div class="w-auto me-3">
                                            <p class=" mb-0 fw-bold">SN</p>
                                            <p class=" mb-0 ">HM</p>
                                            <p class=" mb-0 ">KM</p>
                                            <p class=" mb-0 ">RTD</p>
                                        </div>
                                        <div class="w-auto">
                                            <p class=" mb-0 fw-bold">{{ $tire->serial_number }}</p>
                                            <p class=" mb-0 ">{{ $tire->lifetime_hm }}</p>
                                            <p class=" mb-0 ">{{ $tire->lifetime_km }}</p>
                                            <p class=" mb-0 ">{{ $tire->rtd }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <a data-bs-toggle="modal" data-bs-target="#switchTireModal" data-post="new"
                                            class="btn btn-warning btn-sm"
                                            data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                                            data-position="{{ $position }}" data-tire_id="{{ $tire->id }}"
                                            data-serial_number="{{ $tire->serial_number }}"
                                            data-rtd="{{ $tire->rtd }}" data-hm="{{ $tire->lifetime_hm }}"
                                            data-km="{{ $tire->lifetime_km }}"
                                            data-position="{{ $position }}">ROTATION</a>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger btn-sm dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">REMOVE</button>
                                            <div class="dropdown-menu">
                                                <a data-bs-toggle="modal" data-bs-target="#removeTireModal"
                                                    class="dropdown-item text-uppercase"
                                                    data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                                                    data-position="{{ $position }}"
                                                    data-tire_id="{{ $tire->id }}"
                                                    data-serial_number="{{ $tire->serial_number }}"
                                                    data-rtd="{{ $tire->rtd }}" data-status="SPARE">SPARE</a>
                                                <a data-bs-toggle="modal" data-bs-target="#removeTireModal"
                                                    class="dropdown-item text-uppercase"
                                                    data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                                                    data-position="{{ $position }}"
                                                    data-tire_id="{{ $tire->id }}"
                                                    data-serial_number="{{ $tire->serial_number }}"
                                                    data-rtd="{{ $tire->rtd }}" data-status="REPAIR">REPAIR</a>
                                                <a data-bs-toggle="modal" data-bs-target="#removeTireModal"
                                                    class="dropdown-item text-uppercase"
                                                    data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                                                    data-position="{{ $position }}"
                                                    data-tire_id="{{ $tire->id }}"
                                                    data-serial_number="{{ $tire->serial_number }}"
                                                    data-rtd="{{ $tire->rtd }}" data-status="RETREAD">RETREAD</a>
                                                <a data-bs-toggle="modal" data-bs-target="#removeTireModal"
                                                    class="dropdown-item text-uppercase"
                                                    data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                                                    data-position="{{ $position }}"
                                                    data-tire_id="{{ $tire->id }}"
                                                    data-serial_number="{{ $tire->serial_number }}"
                                                    data-rtd="{{ $tire->rtd }}" data-status="SCRAP">SCRAP</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-3 bg-secondary bg-opacity-10 px-3 py-2 border border-grey">
                                    {{-- <img class="w-100" src="{{ asset('assets/img/tire.png') }}" alt=""> --}}
                                </div>
                                <div class="col-8">
                                    <p class="fw-bold text-primary fs-6 mb-0">POSISI {{ $position }}</p>
                                    <div class="d-flex">
                                        <div class="w-auto me-3">
                                            <p class=" mb-0 fw-bold">SN</p>
                                            <p class=" mb-0 ">HM</p>
                                            <p class=" mb-0 ">KM</p>
                                            <p class=" mb-0 ">RTD</p>
                                        </div>
                                        <div class="w-auto">
                                            <p class=" mb-0 fw-bold">-</p>
                                            <p class=" mb-0 ">-</p>
                                            <p class=" mb-0 ">-</p>
                                            <p class=" mb-0 ">-</p>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <a class="btn btn-primary btn-sm w-100 btnInstallTireModal"
                                            data-bs-toggle="modal" data-bs-target="#installTireModal" data-post="new"
                                            data-position="{{ $position }}">INSTALL</a>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="card page-body d-sm-none d-none d-xxl-block">
        {{-- <div class="card page-body "> --}}
        <div class="card-body px-5 py-4">
            <div class="row gap gap-4 bg-white px-4 py-4"
                style="position: -webkit-sticky;position: sticky;top: 0;z-index: 999;">
                <div class="rounded col-sm border border-primary bg-gradient px-3 py-4 d-flex justify-content-center align-items-center flex-column droppable"
                    data-jenis="SPARE">
                    <i class="text-primary fa-solid fa-box-archive display-3  mb-2"></i>
                    <h4 class="fw-bold text-primary">SPARE</h4>
                </div>
                <div class="rounded col-sm border border-info bg-gradient px-3 py-4 d-flex justify-content-center align-items-center flex-column droppable"
                    data-jenis="REPAIR">
                    <i class="text-info fa-solid fa-gear display-3  mb-2"></i>
                    <h4 class="fw-bold text-info">REPAIR</h4>
                </div>
                {{-- <div class="rounded col-sm border border-secondary bg-gradient px-3 py-4 d-flex justify-content-center align-items-center flex-column droppable"
                    data-jenis="RETREAD">
                    <i class="text-secondary fa-solid fa-circle-dot display-3  mb-2"></i>
                    <h4 class="fw-bold text-secondary">RETREAD</h4>
                </div> --}}
                <div class="rounded col-sm border border-danger bg-gradient px-3 py-4 d-flex justify-content-center align-items-center flex-column droppable"
                    data-jenis="SCRAP">
                    <i class="text-danger fa-solid fa-trash-can display-3  mb-2"></i>
                    <h4 class="fw-bold text-danger">SCRAP</h4>
                </div>
            </div>
            @php
                $position = 0;
            @endphp
            <div class="row mt-4" id="tire_install">
                <div class="col-8 py-4 px-3">
                    @for ($i = 0; $i < $unit_model->axle_2_tire; $i++)
                        <div class="row justify-content-center align-items-end mb-5">
                            <div class="col-auto">
                                <div class="pt-2 text-end">
                                    <p class=" mb-0 fw-bold">SN</p>
                                    <p class=" mb-0 ">Lfetime HM/KM</p>
                                    <p class=" mb-0 ">REPAIR HM/KM</p>
                                    <p class=" mb-0 ">RTD</p>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2">
                                <x-tire-movement :position="++$position" :tire="$tire_running" />
                            </div>
                            <div class="col-auto" style="align-self: center; width:80px ;">
                                <img src="https://imgtr.ee/images/2023/06/08/pux2I.png" class="mb-4"
                                    alt="">
                            </div>
                            <div class="col-sm-2">
                                <x-tire-movement :position="$position" :tire="$tire_running" />
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                    @endfor

                    @for ($i = 0; $i < $unit_model->axle_4_tire; $i++)
                        <div class="row justify-content-center align-items-end mb-5">
                            <div class="col-auto">
                                <div class="pt-2 text-end">
                                    <p class=" mb-0 fw-bold">SN</p>
                                    <p class=" mb-0 ">Lifetime HM/KM</p>
                                    <p class=" mb-0 ">REPAIR HM/KM</p>
                                    <p class=" mb-0 ">RTD</p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <x-tire-movement :position="++$position" :tire="$tire_running" />
                            </div>
                            <div class="col-sm-2">
                                <x-tire-movement :position="$position" :tire="$tire_running" />
                            </div>
                            <div class="col-auto" style="align-self: center; width:80px ;">
                                <img src="https://imgtr.ee/images/2023/06/08/pux2I.png" class="mb-4"
                                    alt="">
                            </div>
                            <div class="col-sm-2">
                                <x-tire-movement :position="++$position" :tire="$tire_running" />
                            </div>
                            <div class="col-sm-2">
                                <x-tire-movement :position="$position" :tire="$tire_running" />
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            Tire Inventory {{ $tire_inventory->count() }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="input-group mb-3">
                                    <input class="form-control" type="text" placeholder="Search"
                                        aria-label="Search" id="searchTire" autofocus>
                                    <a class="input-group-text" href="#">
                                        <i class="search"> Cari</i></a>
                                </div>
                            </div>
                            <div class="overflow-scroll" id="list-tire" style="height: 1080px">
                                @foreach ($tire_inventory as $tire)
                                    <div class="w-full" style="border-bottom: gray 2px solid">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="draggableInventory"
                                                    style="background-image: url({{ asset('assets/img/tire.png') }});"
                                                    data-id="{{ $tire->id }}"
                                                    data-lifetime="{{ $tire->lifetime_km }}"
                                                    data-lifetime="{{ $tire->lifetime_hm }}">
                                                </div>
                                            </div>
                                            <div class="col-9">
                                                <p class="mb-0">{{ $tire->serial_number }}</p>
                                                <div class="row">
                                                    <div class="col-4 pe-0">
                                                        <p class="mb-0">HM</p>
                                                        <p class="mb-0">KM</p>
                                                        <p class="mb-0">Brand</p>
                                                        <p class="mb-0">RTD</p>
                                                        <p class="mb-0">Size</p>
                                                        <p class="mb-0">Pattern</p>
                                                        <p class="mb-0">Status</p>
                                                    </div>
                                                    <div class="col-1">
                                                        <p class="mb-0">:</p>
                                                        <p class="mb-0">:</p>
                                                        <p class="mb-0">:</p>
                                                        <p class="mb-0">:</p>
                                                        <p class="mb-0">:</p>
                                                    </div>
                                                    <div class="col-sm px-0">
                                                        <p class="mb-0">{{ $tire->lifetime_hm ?? '-' }}</p>
                                                        <p class="mb-0">{{ $tire->lifetime_km ?? '-' }}</p>
                                                        <p class="mb-0">
                                                            {{ $tire->tire_size->tire_pattern->manufacture->name ?? '-' }}
                                                        </p>
                                                        <p class="mb-0">{{ $tire->rtd ?? '-' }}</p>
                                                        <p class="mb-0">{{ $tire->tire_size->size ?? '-' }}</p>
                                                        <p class="mb-0">
                                                            {{ $tire->tire_size->tire_pattern->pattern ?? '-' }}
                                                            -
                                                            {{ $tire->tire_size->tire_pattern->type_pattern ?? '-' }}
                                                        </p>
                                                        <p class="mb-0">
                                                            {{ $tire->tire_status->status ?? '-' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="switchTireModal" tabindex="-1" role="dialog"
        aria-labelledby="removeTireModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="removeTireModalLabel">Switch Tire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                        <input type="hidden" name="tire_id_1">
                        <input type="hidden" name="tire_id_2">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 py-3">
                                <p class="mb-2 text-center fw-bold fs-6">Tire 1</p>
                                <div class="row">
                                    <div class="mb-2 col-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="">Tire Position</label>
                                            <input type="text" name="tire_position_switch_1" readonly>
                                            {{-- <select name="tire_position_switch_1" readonly class="form-control">
                                                @for ($i = 0; $i < $unit_model->tire_qty; $i++)
                                                    <option value="{{ $i + 1 }}">{{ $i + 1 }}
                                                    </option>
                                                @endfor
                                            </select> --}}
                                        </div>
                                    </div>
                                    <div class="mb-2 col-6 col-md-6 col-lg-4">
                                        <p class="mb-0 text-secondary">Serial Number</p>
                                        <p class="fs-6 fw-bold" id="serial_number_switch_1"></p>
                                    </div>
                                    <div class="mb-2 col-6 col-md-6 col-lg-4">
                                        <p class="mb-0 text-secondary">RTD</p>
                                        <p class="fs-6 fw-bold" id="rtd_switch_1"></p>
                                    </div>
                                    <div class="mb-2 col-6 col-md-6 col-lg-4">
                                        <p class="mb-0 text-secondary">KM</p>
                                        <p class="fs-6 fw-bold" id="km_tire_switch_1"></p>
                                    </div>
                                    <div class="mb-2 col-6 col-md-6 col-lg-4">
                                        <p class="mb-0 text-secondary">HM</p>
                                        <p class="fs-6 fw-bold" id="hm_tire_switch_1"></p>
                                    </div>
                                </div>
                                <hr class="mb-0">
                            </div>
                            <div class="col-12 col-md-6 col-lg-6 py-3">
                                <p class="mb-2 text-center fw-bold fs-6">Tire 2</p>
                                <div class="row">
                                    <div class="mb-2 col-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="">Tire Position</label>
                                            <select name="tire_position_switch_2" required class="form-control">
                                                <option value="">Pilih</option>
                                                @for ($i = 0; $i < $unit_model->tire_qty; $i++)
                                                    <option value="{{ $i + 1 }}">{{ $i + 1 }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-2 col-6 col-md-6 col-lg-4">
                                        <p class="mb-0 text-secondary">Serial Number</p>
                                        <p class="fs-6 fw-bold" id="serial_number_switch_2"></p>
                                    </div>
                                    <div class="mb-2 col-6 col-md-6 col-lg-4">
                                        <p class="mb-0 text-secondary">RTD</p>
                                        <p class="fs-6 fw-bold" id="rtd_switch_2"></p>
                                    </div>
                                    <div class="mb-2 col-6 col-md-6 col-lg-4">
                                        <p class="mb-0 text-secondary">KM</p>
                                        <p class="fs-6 fw-bold" id="km_tire_switch_2"></p>
                                    </div>
                                    <div class="mb-2 col-6 col-md-6 col-lg-4">
                                        <p class="mb-0 text-secondary">HM</p>
                                        <p class="fs-6 fw-bold" id="hm_tire_switch_2"></p>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group mb-3 col-12">
                                        <label for="">Explanation</label>
                                        <input type="text" name="explanation" class="form-control" required>
                                        <div class="invalid-feedback">Please fill a explanation.</div>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-4 col-lg-4">
                                        <label for="">Unit HM</label>
                                        <input type="text" class="form-control" name="hm_actual"
                                            value="" required>
                                        <div class="text-danger d-none" id="display_error_hm">
                                            <p>HM Tidak Boleh kurang dari sebelumnya</p>
                                        </div>
                                        <div class="invalid-feedback">Please fill a hour meter.</div>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-4 col-lg-4">
                                        <label for="">Unit KM</label>
                                        <input type="text" class="form-control" name="km_actual"
                                            value="" required>
                                        <div class="text-danger d-none" id="display_error_hm">
                                            <p>KM Tidak Boleh kurang dari sebelumnya</p>
                                        </div>
                                        <div class="invalid-feedback">Please fill a hour meter.</div>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-2 col-lg-2">
                                        <label for="">RTD 1</label>
                                        <input type="text" name="rtd_1" class="form-control" required>
                                        <div class="invalid-feedback">Please fill a remaining tread depth.</div>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-2 col-lg-2">
                                        <label for="">RTD 2</label>
                                        <input type="text" name="rtd_2" class="form-control" required>
                                        <div class="invalid-feedback">Please fill a remaining tread depth.</div>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="">Tire 1 Damage</label>
                                        <select class="form-control" name="tire_damage_id_1">
                                            <option value="">Pilih Tire Damage</option>
                                            @foreach ($tire_damage as $item)
                                                <option value="{{ $item->id }}">{{ $item->damage }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="">Tire 2 Damage</label>
                                        <select class="form-control" name="tire_damage_id_2">
                                            <option value="">Pilih Tire Damage</option>
                                            @foreach ($tire_damage as $item)
                                                <option value="{{ $item->id }}">{{ $item->damage }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="">Start time</label>
                                        <input type="datetime-local" name="start_date" class="form-control" required
                                            value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}">
                                        <div class="invalid-feedback">Please fill a time Start.</div>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="">End time</label>
                                        <input type="datetime-local" name="end_date" class="form-control"
                                            value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}" required>
                                        <div class="invalid-feedback">Please fill a time end.</div>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-4">
                                        <label for="">Date Breakdown</label>
                                        <input type="date" name="start_breakdown" class="form-control"
                                            value="{{ \Carbon\Carbon::now(8)->format('Y-m-d') }}" required>
                                        <div class="invalid-feedback">Please fill a start breakdown.</div>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-4">
                                        <label for="">Status Schedule</label>
                                        <select name="status_schedule" required class="form-control">
                                            <option value="">Pilih Status Schedule</option>
                                            <option value="Schedule">Schedule</option>
                                            <option value="Unschedule">Unschedule</option>
                                        </select>
                                        <div class="invalid-feedback">Please fill a status schedule.</div>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-4">
                                        <label for="">Lokasi Breakdown</label>
                                        <select name="lokasi_breakdown" required class="form-control">
                                            <option value="">Pilih Lokasi</option>
                                            <option value="Workshop">Workshop</option>
                                            <option value="Lapangan">Lapangan</option>
                                        </select>
                                        <div class="invalid-feedback">Please fill a lokasi breakdown.</div>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="">PIC Leader</label>
                                        <input type="text" name="pic" class="form-control" required>
                                        <div class="invalid-feedback">Please fill a pic leader.</div>
                                    </div>
                                    <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                        <label for="">PIC Man Power</label>
                                        <input type="text" name="pic_man_power" class="form-control" required>
                                        <div class="invalid-feedback">Please fill a pic man power.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="removeTireModal" tabindex="-1" role="dialog"
        aria-labelledby="removeTireModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="/tirerunning/1">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="removeTireModalLabel">Remove Tire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                        <input type="hidden" name="position">
                        <input type="hidden" name="rtd">
                        <input type="hidden" name="tire_id">
                        <input type="hidden" name="tire_status_id">
                        <input type="hidden" name="hm" value="{{ $unit->hm }}">
                        <div class="row">
                            <div class="mb-2 col-6 col-md-6 col-lg-4">
                                <p class="mb-0 text-secondary">Remove Tire from Unit</p>
                                <p class="fs-6 fw-bold">{{ $unit->unit_number }}</p>
                            </div>
                            <div class="mb-2 col-6 col-md-6 col-lg-4">
                                <p class="mb-0 text-secondary">Position</p>
                                <p class="fs-6 fw-bold" id="position_remove"></p>
                            </div>
                            <div class="mb-2 col-6 col-md-6 col-lg-4">
                                <p class="mb-0 text-secondary">HM unit last update</p>
                                <p class="fs-6 fw-bold">{{ $unit->hm }}</p>
                            </div>
                            <div class="mb-2 col-6 col-md-6 col-lg-4">
                                <p class="mb-0 text-secondary">KM unit last update</p>
                                <p class="fs-6 fw-bold">{{ $unit->km }}</p>
                            </div>
                            <div class="mb-2 col-6 col-md-6 col-lg-4">
                                <p class="mb-0 text-secondary">Tire Serial Number</p>
                                <p class="fs-6 fw-bold" id="tire_serial_number_remove"></p>
                            </div>
                            <div class="mb-2 col-6 col-md-6 col-lg-4">
                                <p class="mb-0 text-secondary">RTD</p>
                                <p class="fs-6 fw-bold" id="rtd_remove"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-4 col-lg-4">
                                <label for="">Unit HM Remove</label>
                                <input type="text" class="form-control" name="hm_actual"
                                    value="0" required>
                                <div class="text-danger d-none" id="display_error_hm">
                                    <p>HM Tidak Boleh kurang dari sebelumnya</p>
                                </div>
                                <div class="invalid-feedback">Please fill a hour meter.</div>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-4 col-lg-4">
                                <label for="">Unit KM Remove</label>
                                <input type="text" class="form-control" name="km_actual"
                                    value="0" required>
                                <div class="text-danger d-none" id="display_error_hm">
                                    <p>KM Tidak Boleh kurang dari sebelumnya</p>
                                </div>
                                <div class="invalid-feedback">Please fill a hour meter.</div>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-4 col-lg-4">
                                <label for="">Tire RTD Remove</label>
                                <input type="text" name="rtd" class="form-control" required>
                                <div class="invalid-feedback">Please fill a remaining tread depth.</div>
                            </div>
                            <div class="form-group mb-3 col-12">
                                <label for="">Explanation</label>
                                <input type="text" name="explanation" class="form-control" required>
                                <div class="invalid-feedback">Please fill a explanation.</div>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="">Tire Damage</label>
                                <select class="form-control" name="tire_damage_id" required>
                                    <option value="">Pilih Tire Damage</option>
                                    @foreach ($tire_damage as $item)
                                        <option value="{{ $item->id }}">{{ $item->damage }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="">Tire Status</label>
                                <input type="text" name="tire_status" class="form-control" required disabled>
                                <div class="invalid-feedback">Please fill a explanation.</div>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="">Start time</label>
                                <input type="datetime-local" name="start_date" class="form-control" required
                                    value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}">
                                <div class="invalid-feedback">Please fill a time Start.</div>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="">End time</label>
                                <input type="datetime-local" name="end_date" class="form-control"
                                    value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}" required>
                                <div class="invalid-feedback">Please fill a time end.</div>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-4">
                                <label for="">Date Breakdown</label>
                                <input type="date" name="start_breakdown" class="form-control"
                                    value="{{ \Carbon\Carbon::now(8)->format('Y-m-d') }}" required>
                                <div class="invalid-feedback">Please fill a start breakdown.</div>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-4">
                                <label for="">Status Schedule</label>
                                <select name="status_schedule" required class="form-control">
                                    <option value="">Pilih Status Schedule</option>
                                    <option value="Schedule">Schedule</option>
                                    <option value="Unschedule">Unschedule</option>
                                </select>
                                <div class="invalid-feedback">Please fill a status schedule.</div>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-4">
                                <label for="">Lokasi Breakdown</label>
                                <select name="lokasi_breakdown" required class="form-control">
                                    <option value="">Pilih Lokasi</option>
                                    <option value="Workshop">Workshop</option>
                                    <option value="Lapangan">Lapangan</option>

                                </select>
                                <div class="invalid-feedback">Please fill a lokasi breakdown.</div>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="">PIC Leader</label>
                                <input type="text" name="pic" class="form-control" required>
                                <div class="invalid-feedback">Please fill a pic leader.</div>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="">PIC Man Power</label>
                                <input type="text" name="pic_man_power" class="form-control" required>
                                <div class="invalid-feedback">Please fill a pic man power.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="installTireModal" tabindex="-1" role="dialog"
        aria-labelledby="installTireModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('tirerunning.store') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="installTireModalLabel">Install Tire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                        <input type="hidden" name="lifetime">
                        <input type="hidden" name="km" value="{{ $unit->km }}">
                        <input type="hidden" name="hm" value="{{ $unit->hm }}">
                        <input type="hidden" name="position">
                        @csrf
                        <div class="row">
                            <div class="mb-2 col-6 col-md-6 col-lg">
                                <p class="mb-0 text-secondary">Install Tire to Unit</p>
                                <p class="fs-6 fw-bold">{{ $unit->unit_number }}</p>
                            </div>
                            <div class="mb-2 col-6 col-md-6 col-lg">
                                <p class="mb-0 text-secondary">Position</p>
                                <p class="fs-6 fw-bold" id="position_install"></p>
                            </div>
                            <div class="mb-2 col-6 col-md-6 col-lg">
                                <p class="mb-0 text-secondary">HM</p>
                                <p class="fs-6 fw-bold">{{ $unit->hm }}</p>
                            </div>
                            <div class="mb-2 col-6 col-md-6 col-lg">
                                <p class="mb-0 text-secondary">KM</p>
                                <p class="fs-6 fw-bold">{{ $unit->km }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="">Tire</label>
                            <select class="select2" name='tire_id' data-minimum-results-for-search='5' required>
                                <option value="">Choose Tire</option>
                                @foreach ($tire_inventory as $item)
                                    <option value="{{ $item->id }}">{{ $item->serial_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Explanation</label>
                            <input type="text" name="explanation" class="form-control" required>
                            <div class="invalid-feedback">Please fill a explanation.</div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="">Start Install</label>
                                <input type="datetime-local" name="start_date" class="form-control"
                                    value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}" required>
                                <div class="invalid-feedback">Please fill a time start.</div>
                            </div>
                            <div class="form-group col">
                                <label for="">End Install</label>
                                <input type="datetime-local" name="end_date" class="form-control"
                                    value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}" required>
                                <div class="invalid-feedback">Please fill a time end.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="">Status Schedule</label>
                                <select name="status_schedule" required class="form-control">
                                    <option value="">Pilih Status Schedule</option>
                                    <option value="Schedule">Schedule</option>
                                    <option value="Unschedule">Unschedule</option>
                                </select>
                                <div class="invalid-feedback">Please fill a status schedule.</div>
                            </div>
                            <div class="form-group mb-3 col-12 col-sm-6 col-md-6 col-lg-6">
                                <label for="">Lokasi Breakdown</label>
                                <select name="lokasi_breakdown" required class="form-control">
                                    <option value="">Pilih Lokasi</option>
                                    <option value="Workshop">Workshop</option>
                                    <option value="Lapangan">Lapangan</option>

                                </select>
                                <div class="invalid-feedback">Please fill a lokasi breakdown.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">PIC Leader</label>
                                <input type="text" name="pic" class="form-control" required>
                                <div class="invalid-feedback">Please fill a pic leader.</div>
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="">PIC Man Power</label>
                                <input type="text" name="pic_man_power" class="form-control" required>
                                <div class="invalid-feedback">Please fill a pic man power.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('assets/js/dragable/jquery-ui.min.js') }}"></script>
        <script>
            $(function() {
                var position_tire_before = 0;
                $('select.select2').select2({
                    dropdownParent: $('#installTireModal')
                });
                var myModalInstall = new bootstrap.Modal(document.getElementById('installTireModal'), {
                    keyboard: false
                });
                var myModalRemove = new bootstrap.Modal(document.getElementById('removeTireModal'), {
                    keyboard: false
                });
                var myModalSwitch = new bootstrap.Modal(document.getElementById('switchTireModal'), {
                    keyboard: false
                });

                $(".draggableUnit").draggable({
                    cursor: "move",
                    revert: true,
                    snap: ".droppableSpare",
                    zIndex: 1000,
                });

                $(".draggableInventory").draggable({
                    cursor: "move",
                    appendTo: '.page-body',
                    // containment: 'window',
                    revert: true,
                    opacity: 70,
                    helper: function(e) {
                        return $(e.target).clone();
                    },
                    start: function() {
                        $(this).hide();
                    },
                    stop: function() {
                        $(this).show()
                    },
                    snap: ".droppableInstall",
                    cursorAt: {
                        top: 50,
                        left: 50
                    },
                    zIndex: 10,


                });

                $(".droppableInstall").droppable({
                    drop: function(e, ui) {
                        var position = $(e.target).data('position');
                        var lifetime = ui.draggable.data('lifetime');
                        var id = ui.draggable.data('id');
                        $('#installTireModal').find('select[name="tire_id"]').val(id).trigger("change");
                        $('#installTireModal').find('input[name="position"]').val(position);
                        $('#installTireModal').find('input[name="lifetime"]').val(lifetime);
                        $('#position_install').html(position);
                        myModalInstall.show();
                    }
                });

                $(".droppable").droppable({
                    accept: '.draggableUnit',
                    drop: function(e, ui) {
                        var status = $(e.target).data('jenis');
                        var id = ui.draggable.data('id');
                        var position = ui.draggable.data('position');
                        var lifetime = ui.draggable.data('lifetime');
                        var tire_id = ui.draggable.data('tire_id');
                        var serial_number = ui.draggable.data('serial_number');
                        var rtd = ui.draggable.data('rtd');
                        let hm_unit_actual = $('#removeTireModal').find(`input[name="hm_actual_check"]`)
                            .val()
                        let action = ui.draggable.data('action');
                        switch (status) {
                            case 'SPARE':
                                $('#removeTireModal').find('input[name="tire_status"]').val(status);
                                $('#removeTireModal').find('input[name="tire_status_id"]').val(2);
                                $('#removeTireModal').find(`select[name="tire_damage_id"]`).attr('required',
                                    false);
                                break;
                            case 'REPAIR':
                                $('#removeTireModal').find('input[name="tire_status"]').val(status);
                                $('#removeTireModal').find('input[name="tire_status_id"]').val(3);
                                $('#removeTireModal').find(`select[name="tire_damage_id"]`).attr('required',
                                    true);
                                break;
                            case 'RETREAD':
                                $('#removeTireModal').find('input[name="tire_status"]').val(status);
                                $('#removeTireModal').find('input[name="tire_status_id"]').val(4);
                                $('#removeTireModal').find(`select[name="tire_damage_id"]`).attr('required',
                                    true);
                                break;
                            case 'SCRAP':
                                $('#removeTireModal').find('input[name="tire_status"]').val(status);
                                $('#removeTireModal').find('input[name="tire_status_id"]').val(5);
                                $('#removeTireModal').find(`select[name="tire_damage_id"]`).attr('required',
                                    true);
                                break;

                            default:
                                break;
                        }
                        $('#removeTireModal').find(`select option`).attr('selected', false);
                        $('#removeTireModal').find(`select option:contains('${status}')`).attr('selected',
                            true);
                        $('#removeTireModal').find('input[name="position"]').val(position);
                        $('#removeTireModal').find('input[name="serial_number"]').val(serial_number);
                        $('#removeTireModal').find('input[name="tire_id"]').val(tire_id);
                        $('#removeTireModal').find('input[name="rtd"]').val(rtd);
                        $('#removeTireModal').find('input[name="rtd_remove"]').val(rtd);
                        $("#tire_serial_number_remove").html(serial_number);
                        $("#rtd_remove").html(rtd);
                        $("#position_remove").html(position);
                        $('#removeTireModal').find('form').attr('action', action);
                        myModalRemove.show();
                    }
                });

                $(".droppableSwitch").droppable({
                    accept: '.draggableUnit',
                    drop: function(e, ui) {
                        let tire_1 = ui.draggable;
                        let tire_2 = $(e.target).children().first();
                        if (tire_1.data("position") == tire_2.data("position")) {
                            return;
                        }
                        position_tire_before = tire_2.data("position");
                        $("#serial_number_switch_1").html(tire_1.data("serial_number"));

                        $("#rtd_switch_1").html(tire_1.data("rtd"));
                        $("#km_tire_switch_1").html(tire_1.data("km"));
                        $("#hm_tire_switch_1").html(tire_1.data("hm"));
                        $("#serial_number_switch_2").html(tire_2.data("serial_number"));

                        $("#rtd_switch_2").html(tire_2.data("rtd"));
                        $("#km_tire_switch_2").html(tire_2.data("km"));
                        $("#hm_tire_switch_2").html(tire_2.data("hm"));



                        $('#switchTireModal').find('input[name="tire_position_switch_1"]').val(tire_1.data(
                            "position"));
                        $('#switchTireModal').find('select[name="tire_position_switch_2"]').val(tire_2.data(
                            "position"));
                        $('#switchTireModal').find('input[name="tire_id_1"]').val(tire_1.data("tire_id"));
                        $('#switchTireModal').find('input[name="tire_id_2"]').val(tire_2.data("id"));
                        $('#switchTireModal').find('input[name="rtd_1"]').val(tire_1.data("rtd"));
                        $('#switchTireModal').find('input[name="rtd_2"]').val(tire_2.data("rtd"));
                        console.log(tire_1.data());

                        let action = ui.draggable.data('action');
                        $('#switchTireModal').find('form').attr('action', action);
                        myModalSwitch.show();
                    }
                });

                $("#switchTireModal").find("select[name='tire_position_switch_2']").change(function(e) {
                    let position = $(e.target).val();
                    let tire_1 = $("#switchTireModal").find("select[name='tire_position_switch_1']");
                    if (position == tire_1.val()) {
                        toastr.error(
                            "tire position should be different",
                            "Error", {
                                closeButton: !0,
                                tapToDismiss: !1,
                                progressBar: !0
                            }
                        )
                        $("#switchTireModal").find("select[name='tire_position_switch_2']").val(
                            position_tire_before);
                        return;
                    }
                    let tire_2 = $("#tire_install").find(`.position_tire_${position}`);
                    $("#serial_number_switch_2").html(tire_2.data("serial_number"));

                    $("#rtd_switch_2").html(tire_2.data("rtd"));
                    $("#km_tire_switch_2").html(tire_2.data("km"));
                    $("#hm_tire_switch_2").html(tire_2.data("hm"));
                    $('#switchTireModal').find('select[name="tire_position_switch_2"]').val(tire_2.data(
                        "position"));
                    $('#switchTireModal').find('input[name="tire_id_2"]').val(tire_2.data("id"));
                    $('#switchTireModal').find('input[name="rtd_2"]').val(tire_2.data("rtd"));
                });
            });

            // mobile
            document.getElementById('installTireModal').addEventListener('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var modal = $(event.target)

                var position = button.data('position')
                if (position) {
                    modal.find('input[name="position"]').val(position);
                }

                modal.find('#position_install').html(position);

            })

            document.getElementById('removeTireModal').addEventListener('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var modal = $(event.target)
                if (position) {
                    var position = button.data('position')
                    modal.find('input[name="position"]').val(position);
                    modal.find('#position_install').html(position);
                    $("#position_remove").html(position);
                }
                if (tire_id) {
                    var tire_id = button.data('tire_id')
                    modal.find('input[name="tire_id"]').val(tire_id);
                }
                if (rtd) {
                    var rtd = button.data('rtd')
                    modal.find('input[name="rtd"]').val(rtd);
                    modal.find('input[name="rtd_remove"]').val(rtd);
                    $("#rtd_remove").html(rtd);
                }
                if (status) {
                    modal.find(`select option`).attr('selected', false);
                    var status = button.data('status')
                    modal.find(`select option:contains('${status}')`).attr('selected', true);
                }
                var serial_number = button.data('serial_number')
                var action = button.data('action')




                modal.find('input[name="serial_number"]').val(serial_number);
                $("#tire_serial_number_remove").html(serial_number);

                modal.find('form').attr('action', action);
            })

            document.getElementById('switchTireModal').addEventListener('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var modal = $(event.target)

                if (position) {
                    var position = button.data('position')
                    $("#position_remove").html(position);
                    modal.find('input[name="position"]').val(position);
                    modal.find('#position_install').html(position);
                }
                if (tire_id) {
                    var tire_id = button.data('tire_id')
                    modal.find('input[name="tire_id"]').val(tire_id);
                }
                if (rtd) {
                    var rtd = button.data('rtd')
                    modal.find('input[name="rtd"]').val(rtd);
                    modal.find('input[name="rtd_remove"]').val(rtd);
                    $("#rtd_remove").html(rtd);

                }
                modal.find(`select option`).attr('selected', false);
                if (status) {
                    var status = button.data('status')
                    modal.find(`select option:contains('${status}')`).attr('selected', true);
                }
                var serial_number = button.data('serial_number')
                if (serial_number) {
                    modal.find('input[name="serial_number"]').val(serial_number);
                    $("#tire_serial_number_remove").html(serial_number);
                }

                var action = button.data('action')
                if (action) {
                    modal.find('form').attr('action', action);
                }

            })

            // document.getElementById('switchTireModal').addEventListener('show.bs.modal', function(event) {
            //     let button = $(event.relatedTarget);
            //     let modal = $(event.target);
            //     $("#serial_number_switch_1").html(button.data("serial_number"));

            //     $("#rtd_switch_1").html(button.data("rtd"));
            //     $("#km_tire_switch_1").html(button.data("km"));
            //     $("#hm_tire_switch_1").html(button.data("hm"));

            //     modal.find('input[name="tire_position_switch_1"]').val(button.data(
            //         "position"));
            //     modal.find('input[name="tire_id_1"]').val(button.data("tire_id"));
            //     modal.find('input[name="rtd_1"]').val(button.data("rtd"));

            //     modal.find('form').attr('action', button.data('action'));
            // })
            $('#widget').draggable();
        </script>
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    scrollX: true
                });
            });

            $('#searchTire').on('keyup', function() {
                var val = $(this).val().toLowerCase().split(" ");
                $('#list-tire .w-full').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
                });
            });
        </script>
    @endpush

</x-app-layout>
