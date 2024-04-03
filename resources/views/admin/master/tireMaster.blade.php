<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Tire Master</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data Tire</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Master</li>
                </ol>
            </nav>
        </div>
        <div class="page-btn">
            <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#form-modal" data-post="new"><img
                    src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Data</a>
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
                {{-- <div class="wordset">
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
                </div> --}}
            </div>
            <!-- /Filter -->
            <div class="card mb-0" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <form action="">
                                <div class="row">
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="tiresite">
                                                <option value="">Choose Site</option>
                                                @foreach ($site as $item)
                                                    <option value="{{ $item->id }}" @selected($item->id == $tiresite_id)>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="tiresize">
                                                <option value="">Choose Size</option>
                                                @foreach ($tiresize as $item2)
                                                    <option value="{{ $item2->id }}" @selected($item2->id == $tiresize_id)>
                                                        {{ $item2->size }}
                                                        {{ $item2->tire_pattern->manufacture->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="tirestatus">
                                                <option value="">Choose Status</option>
                                                @foreach ($tirestatus as $item3)
                                                    <option value="{{ $item3->id }}" @selected($item3->id == $tirestatus_id)>
                                                        {{ $item3->status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-sm-6 col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-filters ms-auto"><img
                                                    src="assets/img/icons/search-whites.svg" alt="img"></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Filter -->
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Site</th>
                            <th>Serial Number</th>
                            <th>Size</th>
                            {{-- <th>Pattern</th> --}}
                            <th>Status</th>
                            <th>Lifetime KM</th>
                            <th>RTD</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="form-modal-edit" data-post="new" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            @csrf
            @method('PUT')
            <div class=" modal-lg modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Tire </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <div class="form-group mb-0">
                                    <label>Site</label>
                                    <select class="select" name="site_id" required>
                                        <option value="">Choose Site</option>
                                        @foreach ($site as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label>Serial Number</label>
                                    <input type="text" name="serial_number">
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="select" name="tire_status_id" required>
                                        <option value="">Choose</option>
                                        @foreach ($tirestatus as $item4)
                                            <option value="{{ $item4->id }}">{{ $item4->status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-5">
                                <div class="form-group">
                                    <label>Compound</label>
                                    <select class="select" name="tire_compound_id" required>
                                        <option value="">Choose</option>
                                        @foreach ($tirecompound as $item3)
                                            <option value="{{ $item3->id }}">{{ $item3->compound }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="form-group">
                                    <label>Size</label>
                                    <select class="select" name="tire_size_id" required>
                                        <option value="">Choose</option>
                                        @foreach ($tiresize as $item2)
                                            <option value="{{ $item2->id }}" data-otd="{{ $item2->otd }}">
                                                {{ $item2->size }} - {{ $item2->tire_pattern->manufacture->name }} -
                                                {{ $item2->tire_pattern->pattern }} -
                                                {{ $item2->tire_pattern->type_pattern }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label>Lifetime HM</label>
                                    <input type="number" class="form-control" value="0" name="lifetime_hm"
                                        required>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label>Lifetime KM</label>
                                    <input type="number" class="form-control" value="0" name="lifetime_km"
                                        required>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label>RTD</label>
                                    <input type="text" class="form-control" value="0" name="rtd"
                                        step="0.1" required>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label>Date </label>
                                    <div class="input-groupicon">
                                        <input type="date" class="form-control" name="date"
                                            value="{{ \Carbon\Carbon::now(8)->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="inputcheck">Repairing
                                    <input type="checkbox" name="is_repairing">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
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

    <!-- Add Modal -->
    <div class="modal fade" id="form-modal" data-post="new" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            @csrf
            <div class=" modal-lg modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Tire </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <div class="form-group mb-0">
                                    <label>Site</label>
                                    <select class="select" name="site_id" required>
                                        <option value="">Choose Site</option>
                                        @foreach ($site as $item)
                                            <option value="{{ $item->id }}" @selected(auth()->user()->site->id ?? null)>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="select" name="tire_status_id" required>
                                        <option value="">Choose</option>
                                        @foreach ($tirestatus as $item4)
                                            <option value="{{ $item4->id }}">{{ $item4->status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label>Date </label>
                                    <div class="input-groupicon">
                                        <input type="date" class="form-control" name="date"
                                            value="{{ \Carbon\Carbon::now(8)->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-5">
                                <div class="form-group">
                                    <label>Compound</label>
                                    <select class="select" name="tire_compound_id" required>
                                        <option value="">Choose</option>
                                        @foreach ($tirecompound as $item3)
                                            <option value="{{ $item3->id }}">{{ $item3->compound }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="form-group">
                                    <label>Size</label>
                                    <select class="select" name="tire_size_id" required>
                                        <option value="">Choose</option>
                                        @foreach ($tiresize as $item2)
                                            <option value="{{ $item2->id }}" data-otd="{{ $item2->otd }}">
                                                {{ $item2->size }} - {{ $item2->tire_pattern->manufacture->name }} -
                                                {{ $item2->tire_pattern->pattern }} -
                                                {{ $item2->tire_pattern->type_pattern }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label>Lifetime HM</label>
                                    <input type="number" class="form-control" value="0" name="lifetime_hm"
                                        required>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label>Lifetime KM</label>
                                    <input type="number" class="form-control" value="0" name="lifetime_km"
                                        required>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label>RTD</label><input type="text" class="form-control" value="0"
                                        name="rtd" required>

                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group">
                                    <label>Total Tire</label>
                                    <input class="form-control" type="number" name="total_tire" value="1"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Upload Xlsx</label>
                                    <div class="image-upload">
                                        <input type="file" id="upload-serial_number"
                                            accept=".csv, application/vnd.ms-excel, .ods">
                                        <div class="image-uploads">
                                            <img src="assets/img/icons/upload.svg" alt="img">
                                            <h4>Drag and drop a file</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Serial Number</label>
                                    <textarea name="serial_number" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="inputcheck">Repairing
                                    <input type="checkbox" name="is_repairing">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
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

    <div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            @can('RESETTIREHISTORY')
                <form method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resetModalLabel">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h5>Are you sure you want to RESET TIRE <span class="text-primary" id="message"></span>
                            </h5>
                        </div>
                        @csrf
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">RESET</button>
                        </div>
                    </div>
                </form>
            @else
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resetModalLabel">Access Denied</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>You not access Reset Tire History <span class="text-primary" id="message"></span></h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            @endcan
        </div>
    </div>

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"
            integrity="sha512-r22gChDnGvBylk90+2e/ycr3RVrDi8DIOkIGNhJlKfuyQM4tIRAI062MaV8sfjQKYVGjOBaZBOA87z+IhZE9DA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("input[name='is_repairing']").change(function() {
                    if ($(this).is(":checked")) {
                        $("select[name='tire_status_id']").val("3").trigger('change');
                    }
                });
                $(function() {
                    var table = $('table.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: window.location.href,
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'site',
                                name: 'site'
                            },
                            {
                                data: 'serial_number',
                                name: 'serial_number'
                            },
                            {
                                data: 'size',
                                name: 'size'
                            },
                            // {
                            //     data: 'tire_pattern_id',
                            //     name: 'tire_pattern_id'
                            // },
                            {
                                data: 'status',
                                name: 'status'
                            },
                            {
                                data: 'lifetime_km',
                                name: 'lifetime_km'
                            },
                            {
                                data: 'rtd',
                                name: 'rtd'
                            },
                            {
                                data: 'date',
                                name: 'date'
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

                $('#resetModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var message = button.data('message');
                    var action = button.data('action');
                    var modal = $(this)
                    modal.find('form').attr('action', action);
                    modal.find('#message').html(message);
                });

                $('#form-modal-edit').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var modal = $(this)
                    var id = button.data('id');
                    $.ajax({
                        method: "GET",
                        url: `{{ route('tiremaster.index') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('select[name="site_id"]').val(response.site_id).trigger(
                            'change');
                        modal.find('input[name="serial_number"]').val(response.serial_number);
                        modal.find('select[name="tire_size_id"]').val(response.tire_size_id)
                            .trigger('change');
                        modal.find('select[name="tire_compound_id"]').val(response.tire_compound_id)
                            .trigger('change');
                        modal.find('select[name="tire_status_id"]').val(response.tire_status_id)
                            .trigger('change');
                        modal.find('input[name="lifetime_hm"]').val(response.lifetime_hm);
                        modal.find('input[name="lifetime_km"]').val(response.lifetime_km);
                        modal.find('input[name="rtd"]').val(response.rtd);
                        modal.find('input[name="date"]').val(response.date);
                        modal.find('input[name="is_repairing"]').prop('checked', response.is_repairing == 1);

                        modal.find('input[name="_method"]').val('PUT');
                    });
                    modal.find('form').attr('action', `{{ route('tiremaster.index') }}/${id}`)
                });


                $('#form-modal').on('hide.bs.modal', function(event) {
                    $(this).find('form')[0].reset();
                    $(this).find('select[name="site_id"]').trigger("change");
                    $(this).find('select[name="tire_size_id"]').trigger("change");
                    $(this).find('select[name="tire_compound_id"]').trigger("change");
                    $(this).find('select[name="tire_status_id"]').trigger("change");
                });

                $('#upload-serial_number').change(handleFile);

                function handleFile(event) {
                    const file = event.target.files[0];
                    if (file != undefined) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const data = new Uint8Array(e.target.result);
                            const workbook = XLSX.read(data, {
                                type: 'array'
                            });
                            const worksheet = workbook.Sheets[workbook.SheetNames[0]];
                            const columnAData = XLSX.utils.sheet_to_json(worksheet, {
                                header: 1
                            });
                            const columnAArray = columnAData.map(cell => cell[0]).join('\n');
                            $("textarea[name='serial_number']").val(columnAArray);
                            $("input[name='total_tire']").val(columnAData.length);
                        };
                        reader.readAsArrayBuffer(file);
                    } else {
                        $("textarea[name='serial_number']").val("");
                        $("input[name='total_tire']").val(1);
                    }
                }

                $("textarea[name='serial_number']").on('input', function(event) {
                    var text = $(this).val();
                    var lineCount = text.split(/\r|\r\n|\n/).length;
                    $("input[name='total_tire']").val(lineCount);
                });

                $("#form-modal select[name='tire_status_id']").change(function() {
                    var status_id = $(this).val();

                    if (status_id == 1) {
                        $('#form-modal input[name="lifetime_hm"]').val(0);
                        $('#form-modal input[name="lifetime_km"]').val(0);
                        $('#form-modal input[name="lifetime_hm"]').attr('readonly', true);
                        $('#form-modal input[name="lifetime_km"]').attr('readonly', true);
                    } else {
                        $('#form-modal input[name="lifetime_hm"]').attr('readonly', false);
                        $('#form-modal input[name="lifetime_km"]').attr('readonly', false);
                    }
                });

                $("#form-modal-edit select[name='tire_status_id']").change(function() {
                    var status_id = $(this).val();

                    if (status_id == 1) {
                        $('#form-modal input[name="lifetime_hm"]').val(0);
                        $('#form-modal input[name="lifetime_km"]').val(0);
                        $('#form-modal input[name="lifetime_hm"]').attr('readonly', true);
                        $('#form-modal input[name="lifetime_km"]').attr('readonly', true);
                    } else {
                        $('#form-modal input[name="lifetime_hm"]').attr('readonly', false);
                        $('#form-modal input[name="lifetime_km"]').attr('readonly', false);
                    }
                });

                $("#form-modal select[name='tire_size_id']").change(function() {
                    let otd = $(this).find(":selected").data("otd");
                    $("#form-modal input[name='rtd']").val(otd)
                    $("#form-modal input[name='rtd']").attr("max", otd)
                });

                $("#form-modal-edit select[name='tire_size_id']").change(function() {
                    let otd = $(this).find(":selected").data("otd");
                    $("#form-modal-edit input[name='rtd']").val(otd)
                    $("#form-modal-edit input[name='rtd']").attr("max", otd)
                });


            });
        </script>
    @endpush
</x-app-layout>
