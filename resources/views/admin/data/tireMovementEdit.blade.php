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
            <h5>Tire Movement Update</h5>
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
    <div class="card page-body">
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
                <div class="rounded col-sm border border-secondary bg-gradient px-3 py-4 d-flex justify-content-center align-items-center flex-column droppable"
                    data-jenis="RETHREAD">
                    <i class="text-secondary fa-solid fa-circle-dot display-3  mb-2"></i>
                    <h4 class="fw-bold text-secondary">RETHREAD</h4>
                </div>
                <div class="rounded col-sm border border-danger bg-gradient px-3 py-4 d-flex justify-content-center align-items-center flex-column droppable"
                    data-jenis="SCRAP">
                    <i class="text-danger fa-solid fa-trash-can display-3  mb-2"></i>
                    <h4 class="fw-bold text-danger">SCRAP</h4>
                </div>
            </div>
            @php
                $position = 0;
                $position2 = 0;
            @endphp
            <div class="row mt-4">
                <div class="col-8 py-4 px-3">
                    {{-- AXLE 2 TIRE --}}
                    @for ($i = 0; $i < $unit_model->axle_2_tire; $i++)
                        <div class="row justify-content-center align-items-end mb-5">
                            <div class="col-auto">
                                <div class="pt-2 text-end">
                                    <p class=" mb-0 fw-bold">SN</p>
                                    <p class=" mb-0 ">HM</p>
                                    <p class=" mb-0 ">KM</p>
                                    <p class=" mb-0 ">repair</p>
                                    <p class=" mb-0 ">Retread</p>
                                    <p class=" mb-0 ">RTD</p>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-2">
                                <figure>
                                    <h4 class="text-center fw-bold">{{ ++$position }}</h4>
                                    @if ($tire = $tire_running->where('position', $position)->pluck('tire')->first())
                                        <div class="bg-secondary bg-opacity-10 px-3 py-2 border border-grey">
                                            <div class="draggableUnit"
                                                style="background-image: url({{ asset('assets/img/tire.png') }});"
                                                data-position="{{ $position }}" data-id="{{ $tire->id }}"
                                                data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                                                data-rtd="{{ $tire->rtd }}"
                                                data-serial_number="{{ $tire->serial_number }}"
                                                data-tire_id="{{ $tire->id }}"
                                                data-lifetime="{{ $tire->lifetime }}">
                                            </div>
                                        </div>
                                        <figcaption class="pt-2">
                                            <p class=" mb-0 fw-bold">{{ $tire->serial_number }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_hm }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_km }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_retread_hm }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_repair_hm }}</p>
                                            <p class=" mb-0">{{ $tire->rtd }}</p>
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
                                            <p class=" mb-0">-</p>
                                        </figcaption>
                                    @endif
                                </figure>
                            </div>
                            <div class="col-auto" style="align-self: center; width:80px ;">
                                <img src="https://imgtr.ee/images/2023/06/08/pux2I.png" class="mb-4" alt="">
                            </div>
                            <div class="col-sm-2">
                                <figure>
                                    <h4 class="text-center fw-bold">{{ ++$position }}</h4>
                                    @if ($tire = $tire_running->where('position', $position)->pluck('tire')->first())
                                        <div class="bg-secondary bg-opacity-10 px-3 py-2 border border-grey">
                                            <div class="draggableUnit"
                                                style="background-image: url({{ asset('assets/img/tire.png') }});"
                                                data-position="{{ $position }}" data-id="{{ $tire->id }}"
                                                data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                                                data-rtd="{{ $tire->rtd }}"
                                                data-serial_number="{{ $tire->serial_number }}"
                                                data-tire_id="{{ $tire->id }}"
                                                data-lifetime="{{ $tire->lifetime }}">
                                            </div>
                                        </div>
                                        <figcaption class="pt-2">
                                            <p class=" mb-0 fw-bold">{{ $tire->serial_number }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_hm }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_km }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_retread_hm }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_repair_hm }}</p>
                                            <p class=" mb-0">{{ $tire->rtd }}</p>
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
                                            <p class=" mb-0">-</p>
                                        </figcaption>
                                    @endif
                                </figure>
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                    @endfor

                    {{-- AXLE 4 TIRE --}}
                    @for ($i = 0; $i < $unit_model->axle_4_tire; $i++)
                        <div class="row justify-content-center align-items-end mb-5">
                            <div class="col-auto">
                                <div class="pt-2 text-end">
                                    <p class=" mb-0 fw-bold">SN</p>
                                    <p class=" mb-0 ">HM</p>
                                    <p class=" mb-0 ">KM</p>
                                    <p class=" mb-0 ">Brand</p>
                                    <p class=" mb-0 ">RTD</p>
                                    <p class=" mb-0 ">Size</p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <figure>
                                    <h4 class="text-center fw-bold">{{ ++$position }}</h4>
                                    @if ($tire = $tire_running->where('position', $position)->pluck('tire')->first())
                                        <div class="bg-secondary bg-opacity-10 px-3 py-2 border border-grey">
                                            <div class="draggableUnit"
                                                style="background-image: url({{ asset('assets/img/tire.png') }});"
                                                data-position="{{ $position }}" data-id="{{ $tire->id }}"
                                                data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                                                data-rtd="{{ $tire->rtd }}"
                                                data-serial_number="{{ $tire->serial_number }}"
                                                data-tire_id="{{ $tire->id }}"
                                                data-lifetime="{{ $tire->lifetime }}">
                                            </div>
                                        </div>
                                        <figcaption class="pt-2">
                                            <p class="mb-0 fw-bold">{{ $tire->serial_number }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_hm }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_km }}</p>
                                            <p class="mb-0">{{ $tire->lifetime_retread_hm }}</p>
                                            <p class="mb-0">{{ $tire->lifetime_repair_hm }}</p>
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
                                            <p class=" mb-0">-</p>
                                        </figcaption>
                                    @endif
                                </figure>
                            </div>
                            <div class="col-sm-2">
                                <figure>
                                    <h4 class="text-center fw-bold">{{ ++$position }}</h4>
                                    @if ($tire = $tire_running->where('position', $position)->pluck('tire')->first())
                                        <div class="bg-secondary bg-opacity-10 px-3 py-2 border border-grey">
                                            <div class="draggableUnit"
                                                style="background-image: url({{ asset('assets/img/tire.png') }});"
                                                data-position="{{ $position }}" data-id="{{ $tire->id }}"
                                                data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                                                data-rtd="{{ $tire->rtd }}"
                                                data-serial_number="{{ $tire->serial_number }}"
                                                data-tire_id="{{ $tire->id }}"
                                                data-lifetime="{{ $tire->lifetime }}">
                                            </div>
                                        </div>
                                        <figcaption class="pt-2">
                                            <p class=" mb-0 fw-bold">{{ $tire->serial_number }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_hm }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_km }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_retread_hm }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_repair_hm }}</p>
                                            <p class=" mb-0">{{ $tire->rtd }}</p>
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
                                            <p class=" mb-0">-</p>
                                        </figcaption>
                                    @endif
                                </figure>
                            </div>
                            <div class="col-auto" style="align-self: center; width:80px ;">
                                <img src="https://imgtr.ee/images/2023/06/08/pux2I.png" class="mb-4"
                                    alt="">
                            </div>
                            <div class="col-sm-2">
                                <figure>
                                    <h4 class="text-center fw-bold">{{ ++$position }}</h4>
                                    @if ($tire = $tire_running->where('position', $position)->pluck('tire')->first())
                                        <div class="bg-secondary bg-opacity-10 px-3 py-2 border border-grey">
                                            <div class="draggableUnit"
                                                style="background-image: url({{ asset('assets/img/tire.png') }});"
                                                data-position="{{ $position }}" data-id="{{ $tire->id }}"
                                                data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                                                data-rtd="{{ $tire->rtd }}"
                                                data-serial_number="{{ $tire->serial_number }}"
                                                data-tire_id="{{ $tire->id }}"
                                                data-lifetime="{{ $tire->lifetime }}">
                                            </div>
                                        </div>
                                        <figcaption class="pt-2">
                                            <p class=" mb-0 fw-bold">{{ $tire->serial_number }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_hm }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_km }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_retread_hm }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_repair_hm }}</p>
                                            <p class=" mb-0">{{ $tire->rtd }}</p>
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
                                            <p class=" mb-0">-</p>
                                        </figcaption>
                                    @endif
                                </figure>
                            </div>
                            <div class="col-sm-2">
                                <figure>
                                    <h4 class="text-center fw-bold">{{ ++$position }}</h4>
                                    @if ($tire = $tire_running->where('position', $position)->pluck('tire')->first())
                                        <div class="bg-secondary bg-opacity-10 px-3 py-2 border border-grey">
                                            <div class="draggableUnit"
                                                style="background-image: url({{ asset('assets/img/tire.png') }});"
                                                data-position="{{ $position }}" data-id="{{ $tire->id }}"
                                                data-action="{{ route('tirerunning.destroy', $tire->tire_running->id) }}"
                                                data-rtd="{{ $tire->rtd }}"
                                                data-serial_number="{{ $tire->serial_number }}"
                                                data-tire_id="{{ $tire->id }}"
                                                data-lifetime="{{ $tire->lifetime }}">
                                            </div>
                                        </div>
                                        <figcaption class="pt-2">
                                            <p class=" mb-0 fw-bold">{{ $tire->serial_number }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_hm }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_km }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_retread_hm }}</p>
                                            <p class=" mb-0">{{ $tire->lifetime_repair_hm }}</p>
                                            <p class=" mb-0">{{ $tire->rtd }}</p>
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
                                            <p class=" mb-0">-</p>
                                        </figcaption>
                                    @endif
                                </figure>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            Tire Inventory
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
                        <table class="w-100">
                            <tr>
                                <th>Remove Tire from Unit</th>
                                <td>:</td>
                                <td><input type="text" class="form-control"
                                        style="background-color: #ffffffff;border: none" name="unit"
                                        value="{{ $unit->unit_number }}" readonly></td>
                            </tr>
                            <tr>
                                <th>HM unit last update</th>
                                <td>:</td>
                                <td><input type="text" class="form-control"
                                        style="background-color: #ffffffff;border: none" name="hm"
                                        value="{{ $unit->hm }}" readonly></td>
                                <th>KM unit last update</th>
                                <td>:</td>
                                <td><input type="text" class="form-control"
                                        style="background-color: #ffffffff;border: none" name="km"
                                        value="{{ $unit->km }}" readonly></td>
                            </tr>
                            <tr>
                                <th>Tire Serial Number</th>
                                <td>:</td>
                                <td><input type="hidden" class="form-control"
                                        style="background-color: #ffffffff;border: none" name="tire_id">
                                    <input type="text" class="form-control"
                                        style="background-color: #ffffffff;border: none" name="serial_number"
                                        readonly>
                                </td>
                                <th>Position</th>
                                <td>:</td>
                                <td><input type="text" class="form-control"
                                        style="background-color: #ffffffff;border: none" name="position" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th>RTD</th>
                                <td>:</td>
                                <td><input type="text" class="form-control"
                                        style="background-color: #ffffffff;border: none" name="rtd" readonly></td>
                            </tr>
                        </table>
                        <hr>
                        <div class="row">
                            <div class="form-group col">
                                <label for="">Tire HM Remove</label>
                                <input type="text" class="form-control" name="hm_actual"
                                    value="{{ $unit->hm }}" required>
                                <div class="text-danger d-none" id="display_error_hm">
                                    <p>HM Tidak Boleh kurang dari sebelumnya</p>
                                </div>
                                <div class="invalid-feedback">Please fill a hour meter.</div>
                            </div>
                            <div class="form-group col">
                                <label for="">Tire KM Remove</label>
                                <input type="text" class="form-control" name="km_actual"
                                    value="{{ $unit->km }}" required>
                                <div class="text-danger d-none" id="display_error_hm">
                                    <p>KM Tidak Boleh kurang dari sebelumnya</p>
                                </div>
                                <div class="invalid-feedback">Please fill a hour meter.</div>
                            </div>
                            <div class="form-group col">
                                <label for="">Tire RTD Remove</label>
                                <input type="text" name="rtd" class="form-control" required>
                                <div class="invalid-feedback">Please fill a remaining tread depth.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="">Tire Damage</label>
                                <select class="form-control" name="tire_damage_id" required>
                                    <option value="">Pilih Tire Damage</option>
                                    @foreach ($tire_damage as $item)
                                        <option value="{{ $item->id }}">{{ $item->damage }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="">Tire Status</label>
                                <select class="form-control" name="tire_status_id" required>
                                    <option value="">Pilih Tire Status</option>
                                    @foreach ($tire_status as $item)
                                        <option value="{{ $item->id }}">{{ $item->status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="">Start time</label>
                                <input type="datetime-local" name="start_date" class="form-control" required
                                    value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}">
                                <div class="invalid-feedback">Please fill a time Start.</div>
                            </div>
                            <div class="form-group col">
                                <label for="">End time</label>
                                <input type="datetime-local" name="end_date" class="form-control"
                                    value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}" required>
                                <div class="invalid-feedback">Please fill a time end.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col">
                                <label for="">Date Breakdown</label>
                                <input type="date" name="start_breakdown" class="form-control"
                                    value="{{ \Carbon\Carbon::now(8)->format('Y-m-d') }}" required>
                                <div class="invalid-feedback">Please fill a start breakdown.</div>
                            </div>
                            <div class="form-group col">
                                <label for="">Status Breakdown</label>
                                <select name="status_breakdown" id="" required class="form-control">
                                    <option value="">Pilih Status Breakdown</option>
                                    <option value="Rotasi">Rotasi</option>
                                    <option value="Matching">Matching</option>
                                    <option value="Backlogrepair">Backlogrepair</option>
                                    <option value="Unschedule">Unschedule</option>
                                </select>
                                <div class="invalid-feedback">Please fill a status breakdown.</div>
                            </div>
                            <div class="form-group col">
                                <label for="">Lokasi Breakdown</label>
                                <select name="lokasi_breakdown" id="" required class="form-control">
                                    <option value="">Pilih Lokasi</option>
                                    <option value="Rotasi">Workshop</option>
                                    <option value="Matching">Lapangan</option>

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
                            <div class="form-group col-md-6">
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
                        <input type="hidden" name="hm" value="{{ $unit->hm }}">
                        <input type="hidden" name="position">
                        @csrf
                        <table>
                            <tr>
                                <th>Install Tire to Unit</th>
                                <td class="px-4">:</td>
                                <td>{{ $unit->unit_number }}</td>
                            </tr>
                            <tr>
                                <th>HM</th>
                                <td class="px-4">:</td>
                                <td>{{ $unit->hm }}</td>
                            </tr>
                            <tr>
                                <th>KM</th>
                                <td class="px-4">:</td>
                                <td>{{ $unit->km }}</td>
                            </tr>
                            <tr>
                                <th>Position</th>
                                <td class="px-4">:</td>
                                <td><input style="border:none" type="text" name="position" readonly></td>
                            </tr>
                        </table>
                        <hr>

                        <div class="form-group">
                            <label for="">Tire</label>
                            <select class="form-control" name='tire_id' required>
                                <option value="">Choose Tire</option>
                                @foreach ($tire_inventory as $item)
                                    <option value="{{ $item->id }}">{{ $item->serial_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Explanation</label>
                            <input type="text" name="explaination" class="form-control" required>
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
        <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
        <script src="{{ asset('assets/js/dragable/jquery-ui.min.js') }}"></script>
        <script>
            $(function() {
                var myModalInstall = new bootstrap.Modal(document.getElementById('installTireModal'), {
                    keyboard: false
                });
                var myModalRemove = new bootstrap.Modal(document.getElementById('removeTireModal'), {
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
                        $('#installTireModal').find('select[name="tire_id"]').val(id);
                        $('#installTireModal').find('input[name="position"]').val(position);
                        $('#installTireModal').find('input[name="lifetime"]').val(lifetime);
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
                        if (status == "SPARE") {
                            $('#removeTireModal').find(`select[name="tire_damage_id"]`).attr('required',
                                false);
                        } else {
                            $('#removeTireModal').find(`select[name="tire_damage_id"]`).attr('required',
                                true);
                        }
                        $('#removeTireModal').find(`select option`).attr('selected', false);
                        $('#removeTireModal').find(`select option:contains('${status}')`).attr('selected',
                            true);
                        $('#removeTireModal').find('input[name="position"]').val(position);
                        $('#removeTireModal').find('input[name="serial_number"]').val(serial_number);
                        $('#removeTireModal').find('input[name="tire_id"]').val(tire_id);
                        $('#removeTireModal').find('input[name="rtd"]').val(rtd);
                        $('#removeTireModal').find('input[name="rtd_remove"]').val(rtd);
                        $('#removeTireModal').find('form').attr('action', action);
                        myModalRemove.show();
                    }
                });
            });
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
