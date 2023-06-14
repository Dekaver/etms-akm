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
                            <form action="">
                                <div class="row">
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="tiresite">
                                                <option value="">Choose Site</option>
                                                @foreach ($site as $item)
                                                    <option value="{{ $item->id }}" @selected($item->id == $tiresite_id)>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="tiresize">
                                                <option value="">Choose Size</option>
                                                @foreach ($tiresize as $item2)
                                                    <option value="{{ $item2->id }}" @selected($item2->id == $tiresize_id)>{{ $item2->size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="tirestatus">
                                                <option value="">Choose Status</option>
                                                @foreach ($tirestatus as $item3)
                                                    <option value="{{ $item3->id }}"  @selected($item3->id == $tirestatus_id)>{{ $item3->status }}</option>
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
                            <th>Lifetime</th>
                            <th>RTD</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- add Modal -->
    <div class="modal fade" id="form-modal" data-post="new" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            @csrf
            @method('PUT')
            <div class=" modal-lg modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Tire </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group mb-0">
                                    <label>Site</label>
                                    <select class="select" name="site_id" required>
                                        <option>Choose Site</option>
                                        @foreach ($site as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Serial Number</label>
                                    <input type="text" name="serial_number" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Size</label>
                                    <select class="select" name="tire_size_id" required>
                                        <option>Choose Size</option>
                                        @foreach ($tiresize as $item2)
                                            <option value="{{ $item2->id }}">{{ $item2->size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Compound</label>
                                    <select class="select" name="tire_compound_id" required>
                                        <option>Choose Compound</option>
                                        @foreach ($tirecompound as $item3)
                                            <option value="{{ $item3->id }}">{{ $item3->compound }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="select" name="tire_status_id" required>
                                        <option>Choose Status</option>
                                        @foreach ($tirestatus as $item4)
                                            <option value="{{ $item4->id }}">{{ $item4->status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Lifetime HM</label>
                                    <input type="text" name="lifetime_hm" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label>Lifetime KM</label>
                                    <input type="text" name="lifetime_km" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>RTD</label>
                                    <input type="text" name="rtd" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Date </label>
                                    <div class="input-groupicon">
                                        <input type="date" class="form-control" name="date"
                                            value="{{ \Carbon\Carbon::now(8)->format('Y-m-d') }}" required>
                                    </div>
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
                            data: 'lifetime_hm',
                            name: 'lifetime_hm'
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

            $('#form-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var post = button.data('post');
                var modal = $(this)
                if (post == 'new') {
                    modal.find('input[name="_method"]').val('POST');
                    modal.find('form').attr('action', `{{ route('tiremaster.store') }}`)
                } else {
                    var id = button.data('id');
                    $.ajax({
                        method: "GET",
                        url: `{{ route('tiremaster.index') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('select[name="site_id"]').val(response.site_id).trigger('change');
                        modal.find('input[name="serial_number"]').val(response.serial_number);
                        modal.find('select[name="tire_size_id"]').val(response.tire_size_id).trigger('change');
                        modal.find('select[name="tire_compound_id"]').val(response.tire_compound_id).trigger(
                            'change');
                        modal.find('select[name="tire_status_id"]').val(response.tire_status_id).trigger(
                            'change');
                        modal.find('input[name="lifetime_hm"]').val(response.lifetime_hm);
                        modal.find('input[name="lifetime_km"]').val(response.lifetime_km);
                        modal.find('input[name="rtd"]').val(response.rtd);
                        modal.find('input[name="date"]').val(response.date);
                        modal.find('input[name="_method"]').val('PUT');
                    });
                    modal.find('form').attr('action', `{{ route('tiremaster.index') }}/${id}`)
                }
            });
            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
                $(this).find('select[name="site_id"]').trigger("change");
                $(this).find('select[name="tire_size_id"]').trigger("change");
                $(this).find('select[name="tire_compound_id"]').trigger("change");
                $(this).find('select[name="tire_status_id"]').trigger("change");
            });
        </script>
    @endpush
</x-app-layout>
