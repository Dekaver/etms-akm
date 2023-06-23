<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Unit</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Unit</li>
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
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="unitmodel">
                                                <option>Choose Unit Model</option>
                                                @foreach ($unit_model as $item)
                                                    <option value="{{ $item->id }}" @selected($item->id == $unitmodel_id)>{{ $item->model }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="sitemodel">
                                                <option>Choose Site</option>
                                                @foreach ($sites as $item2)
                                                    <option value="{{ $item2->id }}" @selected($item2->id == $unitsite_id)>{{ $item2->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select" name="unitstatus">
                                                <option>Choose Status</option>
                                                @foreach ($unit_status as $item3)
                                                    <option value="{{ $item3->id }}" @selected($item3->id == $unitstatus_id)>{{ $item3->status_code }}</option>
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
            <!-- /Table -->
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Site</th>
                            <th>Unit Code</th>
                            <th>Unit Model</th>
                            <th>HM/KM</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- add Modal -->
    <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            @csrf
            @method('PUT')
            <div class=" modal-lg modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Unit </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-6">
                                <div class="form-group">
                                    <label>Unit Code</label>
                                    <input type="text" name="unit_number">
                                </div>
                            </div>
                            <div class="col-lg-6 col-6">
                                <div class="form-group mb-0">
                                    <label>Unit Model</label>
                                    <select class="select" name="unit_model_id">
                                        <option value="">Choose Model</option>
                                        @foreach ($unit_model as $item)
                                            <option value="{{ $item->id }}">{{ $item->model }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Site</label>
                                    <select class="select" name="site_id">
                                        <option value="">Choose Site</option>
                                        @foreach ($sites as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>Unit Status</label>
                                    <select class="select" name="unit_status_id">
                                        <option value="">Choose Status</option>
                                        @foreach ($unit_status as $item)
                                            <option value="{{ $item->id }}">{{ $item->status_code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>HM</label>
                                    <input class="form-control" min="0" type="number" value="0"
                                        name="hm">
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="form-group">
                                    <label>KM</label>
                                    <input class="form-control" min="0" type="number" value="0"
                                        name="km">
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
                            data: 'unit_number',
                            name: 'unit_number'
                        },
                        {
                            data: 'model',
                            name: 'model'
                        },
                        {
                            data: 'value',
                            name: 'value'
                        },
                        {
                            data: 'status',
                            name: 'status'
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
                    modal.find('form').attr('action', `{{ route('unit.store') }}`)
                } else {
                    var id = button.data('id');
                    $.ajax({
                        method: "GET",
                        url: `{{ route('unit.index') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('input[name="unit_number"]').val(response.unit_number);
                        modal.find('select[name="unit_model_id"]').val(response.unit_model_id)
                            .trigger('change');
                        modal.find('select[name="site_id"]').val(response.site_id).trigger('change');
                        modal.find('select[name="unit_status_id"]').val(response.unit_status_id)
                            .trigger('change');
                        modal.find('input[name="hm"]').val(response.hm);
                        modal.find('input[name="km"]').val(response.km);

                        modal.find('input[name="_method"]').val('PUT');
                    });
                    modal.find('form').attr('action', `{{ route('unit.index') }}/${id}`)
                }
            });
            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
                $(this).find('select[name="unit_model"]').trigger('change');
                $(this).find('select[name="site_id"]').trigger('change');
                $(this).find('select[name="unit_status_id"]').trigger('change');
            });
        </script>
    @endpush
</x-app-layout>
