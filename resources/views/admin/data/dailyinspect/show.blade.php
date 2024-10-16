<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Daily Monitoring</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daily Monitoring</li>
                </ol>
            </nav>
        </div>
        <div class="page-btn">
            <div class="flex">
                <div class="col">
                    <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#form-modal-add"
                        data-post="new"><img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img"
                            class="me-1">Add Data</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- /Filter -->
            <div class="card mb-0" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Pattern</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Brand</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Size</option>
                                            <option>-</option>
                                            <option>-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12">
                                    <div class="form-group">
                                        <a class="btn btn-filters ms-auto"><img
                                                src="{{ asset('assets/img/icons/search-whites.svg') }}"
                                                alt="img"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Table -->
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Unit</th>
                            <th>HM</th>
                            <th>KM</th>
                            <th>status</th>
                            <th>Last Update</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="form-modal-add" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            @csrf
            <div class=" modal-xl modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tire Inspection</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Unit number</label>
                                    <input type="text" name="unit_number" value="{{ $unit->unit_number }}" disabled>
                                    <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <input type="text" name="shift" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    {{-- <label>Date</label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required> --}}
                                    <label for="">Start</label>
                                    <input type="datetime-local" name="start_date" class="form-control"
                                        value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}" required>
                                    <div class="invalid-feedback">Please fill a time start.</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    {{-- <label>Time</label>
                                    <input type="time" name="time" class="form-control"
                                        value="{{ \Carbon\Carbon::now()->format('h:i') }}" required> --}}
                                    <label for="">End</label>
                                    <input type="datetime-local" name="end_date" class="form-control"
                                        value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}" required>
                                    <div class="invalid-feedback">Please fill a time end.</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>HM</label>
                                    <x-input-number class="form-control" name="hm" id="hm_create"
                                        min="{{ $unit->hm }}" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>KM</label>
                                    <x-input-number class="form-control" name="km" id="km_create"
                                        min="{{ $unit->km }}" required />
                                </div>
                            </div>
                            {{-- <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Tyre Man</label>
                                    <input type="text" name="pic" required>
                                </div>
                            </div> --}}

                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Driver</label>
                                    <select class="form-select" name="driver_id" required>
                                        <option value="">Pilih Driver</option>
                                        @foreach ($driver as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label for="">PIC Leader</label>
                                    <select class="form-select" name="pic_id" required>
                                        <option value=""></option>
                                        @foreach ($teknisi as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == ($pic_id ?? ''))>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please fill a pic leader.</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label for="">Foreman</label>
                                    {{-- <input type="text" name="pic_man_power" class="form-control" required> --}}
                                    <select class="js-example-basic-multiple" id="foreman" name="foreman[]"
                                        multiple="multiple">
                                        @foreach ($teknisi as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please fill a foreman.</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label for="">PIC Man Power</label>
                                    {{-- <input type="text" name="pic_man_power" class="form-control" required> --}}
                                    <select class="js-example-basic-multiple" id="man_power" name="manpower[]"
                                        multiple="multiple">
                                        @foreach ($teknisi as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please fill a pic man power.</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <input id="full_tire" type="checkbox" checked value="true">
                                <label for="full_tire">Full Tire</label>
                            </div>
                        </div>

                        <div class="table-responsive" style="overflow-x: scroll; white-space:nowrap">
                            <table class="table table-bordered" id="table-tire-inspection">
                                <thead>
                                    <tr>
                                        <th style="display: none;">#</th>
                                        <th style="width: 40px">Pos</th>
                                        <th>Serial Number</th>
                                        <th style="width: 100px">Pressure</th>
                                        <th style="width: 100px">Dept Thread</th>
                                        <th style="min-width: 100px">Tire</th>
                                        <th style="min-width: 100px">Tube</th>
                                        <th style="min-width: 100px">Flap</th>
                                        <th style="min-width: 100px">Rim</th>
                                        <th>T.Pentil</th>
                                        <th style="min-width: 200px">Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unit->tire_runnings as $tire_running)
                                        <tr>
                                            <td style="display: none;">
                                                <input type="checkbox" checked
                                                    name="is_selected[{{ $tire_running->position }}]">
                                            </td>
                                            <td>
                                                {{ $tire_running->position }}
                                                <input type="hidden" name="position[{{ $tire_running->position }}]"
                                                    value="{{ $tire_running->position }}">
                                            </td>
                                            <td>
                                                {{ $tire_running->tire->serial_number }}
                                                <input type="hidden"
                                                    name="serial_number[{{ $tire_running->position }}]"
                                                    value="{{ $tire_running->tire->serial_number }}">
                                            </td>
                                            <td>
                                                <input class="form-control" type="number" min="0"
                                                    max="999" name="pressure[{{ $tire_running->position }}]"
                                                    required>
                                            </td>
                                            <td>
                                                <input class="form-control" type="number" min="0"
                                                    max="999" name="rtd[{{ $tire_running->position }}]"
                                                    step="0.1" required>
                                            </td>
                                            <td>
                                                <select class="form-control"
                                                    name="tire_condition[{{ $tire_running->position }}]">
                                                    <option>Good</option>
                                                    <option>Bad</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control"
                                                    name="tire_tube[{{ $tire_running->position }}]">
                                                    <option>Good</option>
                                                    <option>Bad</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control"
                                                    name="tire_flap[{{ $tire_running->position }}]">
                                                    <option>Good</option>
                                                    <option>Bad</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control"
                                                    name="tire_rim[{{ $tire_running->position }}]">
                                                    <option>Good</option>
                                                    <option>Bad</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="checkbox" checked
                                                    name="tire_t_pentil[{{ $tire_running->position }}]">
                                            </td>
                                            <td>
                                                <input class="form-control" type="text"
                                                    name="remark[{{ $tire_running->position }}]">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-submit">Save</button>
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Modal Update --}}
    <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            @csrf
            @method('PUT')
            <div class=" modal-xl modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tire Inspection</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Unit number</label>
                                    <input type="text" name="unit_number" value="{{ $unit->unit_number }}"
                                        disabled>
                                    <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <input type="text" name="shift" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    {{-- <label>Date</label>
                                    <input type="date" name="date" class="form-control" required> --}}
                                    <label for="">Start</label>
                                    <input type="datetime-local" name="start_date" class="form-control"
                                        value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}" required>
                                    <div class="invalid-feedback">Please fill a time start.</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    {{-- <label>Time</label>
                                    <input type="time" name="time" class="form-control" required> --}}
                                    <label for="">End</label>
                                    <input type="datetime-local" name="end_date" class="form-control"
                                        value="{{ \Carbon\Carbon::now(8)->format('Y-m-d h:i') }}" required>
                                    <div class="invalid-feedback">Please fill a time end.</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>HM</label>
                                    <x-input-number class="form-control" name="hm" id="hm_update"
                                        min="{{ $unit->hm }}" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>KM</label>
                                    <x-input-number class="form-control" name="km" id="km_update"
                                        min="{{ $unit->km }}" required />
                                </div>
                            </div>
                            {{-- <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Tyre Man</label>
                                    <input class="form-control" type="text" name="pic" required>
                                </div>
                            </div> --}}
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Driver</label>
                                    <select class="form-control" name="driver_id" required>
                                        <option value="">Pilih Driver</option>
                                        @foreach ($driver as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label for="">PIC Leader</label>
                                    <select class="form-select" name="pic_id" required>
                                        <option value=""></option>
                                        @foreach ($teknisi as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == ($pic_id ?? ''))>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please fill a pic leader.</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label for="">Foreman</label>
                                    {{-- <input type="text" name="pic_man_power" class="form-control" required> --}}
                                    <select class="js-example-basic-multiple" id="foreman3" name="foreman[]"
                                        multiple="multiple">
                                        @foreach ($teknisi as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please fill a foreman.</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label for="">PIC Man Power</label>
                                    {{-- <input type="text" name="pic_man_power" class="form-control" required> --}}
                                    <select class="js-example-basic-multiple" id="man_power3" name="manpower[]"
                                        multiple="multiple">
                                        @foreach ($teknisi as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please fill a pic man power.</div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <input id="full_tire_edit" type="checkbox" checked value="true">
                                <label for="full_tire_edit">Full Tire</label>
                            </div>
                        </div>

                        <div class="table-responsive" style="overflow-x: scroll; white-space:nowrap">
                            <table class="table table-bordered" id="table-tire-inspection-edit">
                                <thead>
                                    <tr>
                                        <th style="display: none;">#</th>
                                        <th style="width: 40px">Pos</th>
                                        <th>Serial Number</th>
                                        <th style="width: 100px">Pressure</th>
                                        <th style="width: 100px">Dept Thread</th>
                                        <th style="min-width: 100px">Tire</th>
                                        <th style="min-width: 100px">Tube</th>
                                        <th style="min-width: 100px">Flap</th>
                                        <th style="min-width: 100px">Rim</th>
                                        <th>T.Pentil</th>
                                        <th style="min-width: 200px">Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-submit">Save</button>
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    @push('js')
        <script src="{{ asset('assets/js/dragable/jquery-ui.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#foreman3').select2();
                $('#man_power3').select2();
            });
            var id_unit = @json($unit->id);
            $(function() {
                var table = $('table.data-table').DataTable({

                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('dailyinspect.index') }}/" + id_unit,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'unit_number',
                            name: 'unit_number'
                        },
                        {
                            data: 'updated_hm_unit',
                            name: 'updated_hm_unit'
                        },
                        {
                            data: 'updated_km_unit',
                            name: 'updated_km_unit'
                        },
                        {
                            data: 'unit_status',
                            name: 'unit_status'
                        },
                        {
                            data: 'last_update',
                            name: 'last_update'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });


            });

            $('#form-modal-add').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var post = button.data('post');
                var modal = $(this)

                var id = button.data('id');
                modal.find('input[name="_method"]').val("POST")
                modal.find('form').attr('action', `{{ route('dailyinspect.index') }}`)

            });

            $('#form-modal-add').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
                $(this).find('select[name="site_id"]').trigger('change');
                $(this).find('select[name="unit_status_id"]').trigger('change');
            });

            $('#form-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var modal = $(this);
                var id = button.data('id');
                $('#foreman3').select2('destroy').select2();
                $('#man_power3').select2('destroy').select2();


                $.ajax({
                    method: "GET",
                    url: `{{ route('dailyinspect.index') }}/${id}/edit`
                }).done(function(response) {
                    // Isi field form umum
                    modal.find("input[name='date']").val(response.date ?? '');
                    modal.find("input[name='time']").val(response.time ?? '');
                    modal.find("input[name='pic']").val(response.pic ?? '');
                    modal.find("input[name='driver']").val(response.driver ?? '');
                    modal.find("input[name='shift']").val(response.shift ?? '');
                    modal.find("input[name='km']").val(response.updated_km_unit ?? '');
                    modal.find("input[name='hm']").val(response.updated_hm_unit ?? '');
                    modal.find("input[name='km']").prop("min", response.km_unit);
                    modal.find("input[name='hm']").prop("min", response.hm_unit);

                    modal.find("input[name='start_date']").val(response.start_date ?? '');
                    modal.find("input[name='end_date']").val(response.end_date ?? '');
                    modal.find("select[name='driver_id']").val(response.driver_id ?? '');
                    modal.find("select[name='pic_id']").val(response.pic_id ?? '');

                    // Set selected options for foreman and manpower
                    $('#foreman3').val(response.selectedForeman).select().trigger('change');
                    $('#man_power3').val(response.selectedManPower).select().trigger('change');

                    console.log('Selected Foreman:', response.selectedForeman);
                    console.log('Selected Manpower:', response.selectedManPower);

                    // Kosongkan tabel inspeksi ban sebelum menambahkan data baru
                    $('#table-tire-inspection-edit tbody').empty();

                    // Template elemen yang akan digunakan berulang
                    var tire_damage = `
            <td>
                <select class="form-control">
                    <option value="">Tire damage</option>
                    @foreach ($tire_damages as $item)
                    <option value="{{ $item->id }}">{{ $item->damage }}</option>
                    @endforeach
                </select>
            </td>`;
                    var condition = `
            <td>
                <select class="form-control">
                    <option>Good</option>
                    <option>Bad</option>
                </select>
            </td>`;
                    var check = `
            <td class="text-center">
                <input type="checkbox" checked>
            </td>`;
                    var text = `
            <td>
                <input class="form-control" type="text">
            </td>`;

                    // Isi tabel dengan data detail inspeksi ban
                    $.each(response.details, function(i, v) {
                        // Generate elemen yang bisa diulang
                        let tire = $(condition).clone();
                        tire.find('select').attr('name', `tire_condition[${v.position}]`);

                        let tube = $(condition).clone();
                        tube.find('select').val(v.tube);
                        tube.find('select').attr('name', `tire_tube[${v.position}]`);

                        let flap = $(condition).clone();
                        flap.find('select').val(v.flap);
                        flap.find('select').attr('name', `tire_flap[${v.position}]`);

                        let rim = $(condition).clone();
                        rim.find('select').val(v.rim);
                        rim.find('select').attr('name', `tire_rim[${v.position}]`);

                        let t_pentil = $(check).clone();
                        t_pentil.find('input').prop('checked', v.t_pentil == "1" ? true : false);
                        t_pentil.find('input').attr('name', `tire_t_pentil[${v.position}]`);

                        let remark = $(text).clone();
                        remark.find('input').val(v.remark);
                        remark.find('input').attr('name', `remark[${v.position}]`);

                        // Buat baris baru untuk setiap detail ban
                        var tr = $('<tr>').html(`
                <td ${$("#full_tire_edit").is(':checked') ? 'style="display: none;"' : '' }>
                    <input type="checkbox" ${v.is_selected == 1 ? 'checked' : ''}
                        name="is_selected[${v.position}]">
                </td>
                <td>
                    ${v.position}
                    <input type="hidden" name="position[${v.position}]" value="${v.position}">
                </td>
                <td>${v.tire.serial_number}
                    <input type="hidden" name="serial_number[${v.position}]" value="${v.tire.serial_number}">
                </td>
                <td><input class="form-control" type="number" name="pressure[${v.position}]" value="${v.pressure ?? 0}"></td>
                <td><input class="form-control" type="number" name="rtd[${v.position}]" step="0.1" value="${v.rtd}"></td>
            `);

                        // Tambahkan elemen ke dalam baris
                        tire.appendTo(tr);
                        tube.appendTo(tr);
                        flap.appendTo(tr);
                        rim.appendTo(tr);
                        t_pentil.appendTo(tr);
                        remark.appendTo(tr);

                        // Tambahkan baris ke dalam tabel
                        tr.appendTo("#table-tire-inspection-edit tbody");

                        if (v.is_selected == false) {
                            $("#full_tire_edit").prop('checked', false).trigger('change');
                        }
                    });

                    // Set form action untuk update
                    modal.find('form').attr('action', `{{ route('dailyinspect.index') }}/${id}`);
                });
            });


            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
                $(this).find('select[name="site_id"]').trigger('change');
                $(this).find('select[name="unit_status_id"]').trigger('change');
            });

            $("#full_tire").on('change', function(event) {
                if ($(this).is(':checked')) {
                    $("#table-tire-inspection td input[type='checkbox']").prop('checked', true).trigger('change');
                    $("#table-tire-inspection th:first-child, #table-tire-inspection td:first-child").hide();
                } else {
                    $("#table-tire-inspection th:first-child, #table-tire-inspection td:first-child").show();
                }
            });

            $("#full_tire_edit").on('change', function(event) {
                if ($(this).is(':checked')) {
                    $("#table-tire-inspection-edit td input[type='checkbox']").prop('checked', true).trigger('change');
                    $("#table-tire-inspection-edit th:first-child, #table-tire-inspection-edit td:first-child").hide();
                } else {
                    $("#table-tire-inspection-edit th:first-child, #table-tire-inspection-edit td:first-child").show();
                }
            });

            $(document).ready(function() {
                // Attach change event handler to checkboxes with class "tire_t_pentil"
                $('table tbody input[name^="is_selected"]').on('change', function() {
                    console.log($(this));
                    // Get the corresponding pressure and rtd input fields
                    var pressureInput = $(this).closest('tr').find('input[name^="pressure"]');
                    var rtdInput = $(this).closest('tr').find('input[name^="rtd"]');

                    // Set or remove the "required" attribute based on the checkbox state
                    if ($(this).is(':checked')) {
                        pressureInput.prop('required', true);
                        rtdInput.prop('required', true);
                    } else {
                        pressureInput.prop('required', false);
                        rtdInput.prop('required', false);
                    }
                });
            });
        </script>
    @endpush

    @push('css')
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            input[type=number] {
                -moz-appearance: textfield;
            }
        </style>
    @endpush
</x-app-layout>
