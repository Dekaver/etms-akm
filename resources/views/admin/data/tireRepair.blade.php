<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Tire Repair</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Repair</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            {{-- <div class="table-top">
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
            </div> --}}
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
            <!-- /Filter -->
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Site</th>
                            <th>Serial Number</th>
                            <th>Size</th>
                            <th>Pattern</th>
                            <th>Compound</th>
                            <th>Status</th>
                            <th>RTD</th>
                            <th>Lifetime</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>


    <!-- add Modal -->
    <div class="modal fade" id="form-modal-spare" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            <input type="hidden" name="tire_id">
            <input type="hidden" name="tire_status_id">
            @csrf
            @method('PUT')
            <div class=" modal-lg modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Status To Spare </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Site</label>
                                    <input type="text" name="site" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Serial Number</label>
                                    <input type="text" name="serial_number" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Tire Lifetime HM</label>
                                    <input type="text" name="lifetime_hm" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Tire Lifetime KM</label>
                                    <input type="text" name="lifetime_km" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>RTD</label>
                                    <input type="text" name="rtd" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Man Power</label>
                                    <input type="text" name="man_power">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Material</label>
                                    <input type="text" name="material">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="datetime-local" class="form-control" name="start_date"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="datetime-local" class="form-control" name="end_date"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>PIC</label>
                                    <input type="text" name="pic">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tire Status Update</label>
                                    <input type="text" name="tire_status" value="SPARE" readonly>
                                </div>
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

    <div class="modal fade" id="form-modal-scrap" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            <input type="hidden" name="tire_id">
            <input type="hidden" name="tire_status_id">
            @csrf
            @method('PUT')
            <div class=" modal-lg modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Status To Scrap </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Site</label>
                                    <input type="text" name="site" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Serial Number</label>
                                    <input type="text" name="serial_number" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Tire Lifetime HM</label>
                                    <input type="text" name="lifetime_hm" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Tire Lifetime KM</label>
                                    <input type="text" name="lifetime_km" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>RTD</label>
                                    <input type="text" name="rtd" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Reason</label>
                                    <input type="text" name="man_power">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tire Damage</label>
                                    <select name="tire_damage_id" class="form-control">
                                        <option value="">Select Damage</option>
                                        @foreach ($tire_damages as $item)
                                            <option value="{{ $item->id }}">{{ $item->damage }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="datetime-local" class="form-control" name="start_date"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="datetime-local" class="form-control" name="end_date"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>PIC</label>
                                    <input type="text" name="pic">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tire Status Update</label>
                                    <input type="text" name="tire_status" value="SCRAP" readonly>
                                </div>
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

    @push('js')
        <script type="text/javascript">
            $(function() {
                var table = $('table.data-table').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('tirerepair.index') }}",
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
                        {
                            data: 'pattern',
                            name: 'pattern'
                        },
                        {
                            data: 'compound',
                            name: 'compound'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'lifetime_hm',
                            name: 'lifetime_hm'
                        },
                        {
                            data: 'lifetime_km',
                            name: 'lifetime_km'
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

            $('#form-modal-spare').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var post = button.data('post');
                var modal = $(this)
                var id = button.data('id');
                $.ajax({
                    method: "GET",
                    url: `{{ route('tirerepair.index') }}/${id}/edit`
                }).done(function(response) {
                    modal.find('input[name="site"]').val(response.site.name);
                    modal.find('input[name="serial_number"]').val(response.serial_number);
                    modal.find('input[name="tire_id"]').val(response.id);
                    modal.find('input[name="lifetime_hm"]').val(response.lifetime_hm);
                    modal.find('input[name="lifetime_km"]').val(response.lifetime_km);
                    modal.find('input[name="tire_status_id"]').val(response.tire_status_id);
                    modal.find('input[name="rtd"]').val(response.rtd);
                });
                modal.find('form').attr('action', `{{ route('tirerepair.index') }}/${id}`)
            });

            $('#form-modal-scrap').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var post = button.data('post');
                var modal = $(this)
                var id = button.data('id');
                $.ajax({
                    method: "GET",
                    url: `{{ route('tirerepair.index') }}/${id}/edit`
                }).done(function(response) {
                    modal.find('input[name="site"]').val(response.site.name);
                    modal.find('input[name="tire_id"]').val(response.id);
                    modal.find('input[name="serial_number"]').val(response.serial_number);
                    modal.find('input[name="lifetime_hm"]').val(response.lifetime_hm);
                    modal.find('input[name="lifetime_km"]').val(response.lifetime_km);
                    modal.find('input[name="rtd"]').val(response.rtd);
                    modal.find('input[name="tire_status_id"]').val(response.tire_status_id);
                });
                modal.find('form').attr('action', `{{ route('tirerepair.index') }}/${id}`)
            });
            $('#form-modal-scrap').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
                $(this).find('select[name="tire_damage_id"]').trigger('change');
            });
            $('#form-modal-spare').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
            });
        </script>
    @endpush
</x-app-layout>
