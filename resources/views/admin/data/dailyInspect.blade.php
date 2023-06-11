<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Tire Running Unit</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Running Unit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-path">
                        <a class="btn btn-filter" id="filter_search">
                            <img src="assets/img/icons/filter.svg" alt="img">
                            <span><img src="assets/img/icons/closes.svg" alt="img"></span>
                        </a>
                    </div>
                    <div class="search-input">
                        <a class="btn btn-searchset"><img src="assets/img/icons/search-white.svg" alt="img"></a>
                    </div>
                </div>
                <div class="wordset">
                    <ul>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                    src="assets/img/icons/pdf.svg" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                    src="assets/img/icons/excel.svg" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                    src="assets/img/icons/printer.svg" alt="img"></a>
                        </li>
                    </ul>
                </div>
            </div>
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
                                        <a class="btn btn-filters ms-auto"><img src="assets/img/icons/search-whites.svg"
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
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Unit number</label>
                                    <input type="text" name="unit_number">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>HM</label>
                                    <input type="text" name="hm">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>KM</label>
                                    <input type="text" name="km">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" name="date"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Location</label>
                                    <input type="text" name="location">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <input type="text" name="shift">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Tyre Man</label>
                                    <input type="text" name="pic">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Driver</label>
                                    <input type="text" name="driver">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" style="overflow-x: scroll; white-space:nowrap">
                            <table class="table table-bordered" id="table-tire-inspection">
                                <thead>
                                    <tr>
                                        <th style="width: 40px">Pos</th>
                                        <th>Serial Number</th>
                                        <th style="width: 100px">Pressure</th>
                                        <th style="width: 100px">Dept Thread</th>
                                        <th>Tube</th>
                                        <th>Flap</th>
                                        <th>Rim</th>
                                        <th>T.Pentil</th>
                                        <th>Remark</th>
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
        <script type="text/javascript">
            $(function() {
                var table = $('table.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('dailyinspect.index') }}",
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
                            data: 'hm',
                            name: 'hm'
                        },
                        {
                            data: 'km',
                            name: 'km'
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

            $('#form-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var post = button.data('post');
                var modal = $(this)

                var id = button.data('id');
                $.ajax({
                    method: "GET",
                    url: `{{ route('dailyinspect.index') }}/${id}/edit`
                }).done(function(response) {
                    console.log(response);

                    $('#table-tire-inspection tbody').empty();
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
                        </td>`
                    var check = `
                        <td class="text-center">
                            <input type="checkbox" checked>
                        </td>`
                    $.each(response, function(i, v) {
                        let tire_damage_new = $(tire_damage).clone();
                        tire_damage_new.find('select').val(v.tire_damage_id);
                        tire_damage_new.find('select').attr('name', `tire_damage_id[${v.position}]`)

                        let tube = $(condition).clone();
                        // tube.find('select').val(v.tube);
                        tube.find('select').attr('name', `tire_tube[${v.position}]`)

                        let flap = $(condition).clone();
                        // flap.find('select').val(v.flap);
                        flap.find('select').attr('name', `tire_flap[${v.position}]`)

                        let rim = $(condition).clone();
                        // rim.find('select').val(v.rim);
                        rim.find('select').attr('name', `tire_rim[${v.position}]`)

                        let t_pentil = $(check).clone();
                        // t_pentil.find('select').val(v.t_pentil);
                        t_pentil.find('input').attr('name', `tire_t_pentil[${v.position}]`)

                        var tr = $('<tr>').html(`
                            <input type="hidden" name="tire_id[${v.position}]" value="${v.tire.id}">
                            <input type="hidden" name="position[${v.position}]" value="${v.position}">
                            <input type="hidden" name="serial_number[${v.position}]" value="${v.tire.serial_number}">
                            <input type="hidden" name="lifetime_hm[${v.position}]" value="${v.tire.lifetime_hm}">
                            <input type="hidden" name="lifetime_km[${v.position}]" value="${v.tire.lifetime_km}">
                            <td>${v.position}</td>
                            <td>${v.tire.serial_number}</td>
                            <td><input class="form-control" type="number" name="pressure[${v.position}]" value="${v.tire.pressure ?? 0 }"></td>
                            <td><input class="form-control" type="number" name="rtd[${v.position}]" value="${v.tire.rtd}"></td>
                            `);
                        tube.appendTo(tr);
                        flap.appendTo(tr);
                        rim.appendTo(tr);
                        t_pentil.appendTo(tr);
                        tire_damage_new.appendTo(tr);
                        tr.appendTo("#table-tire-inspection tbody");
                    });
                });
                modal.find('input[name="unit_number"]').val(button.data('unit_number'));
                modal.find('input[name="hm"]').val(button.data('hm'));
                modal.find('input[name="km"]').val(button.data('km'));
                modal.find('form').attr('action', `{{ route('dailyinspect.index') }}/${id}`)

            });
            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
                $(this).find('select[name="unit_number"]').trigger('change');
                $(this).find('select[name="site_id"]').trigger('change');
                $(this).find('select[name="unit_status_id"]').trigger('change');
            });
        </script>
    @endpush

</x-app-layout>
