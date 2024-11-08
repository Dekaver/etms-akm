<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Tire Size</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data Tire</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Size</li>
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
                        <a class="btn btn-filter {{ $tire_pattern || $tire_manufacture || $tire_size ? ' setclose' : '' }}"
                            id="filter_search">
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
            <div class="card mb-0" id="filter_inputs"
                {{ $tire_pattern || $tire_manufacture || $tire_size ? 'style=display:block' : '' }}>
                <div class="card-body pb-0">
                    <form action="">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select" name="tire_pattern">
                                        <option value="">Choose Pattern</option>
                                        @foreach ($tire_patterns as $item)
                                            <option value="{{ $item->pattern }}" @selected($item->pattern == $tire_pattern)>
                                                {{ $item->pattern }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select" name="tire_manufacture">
                                        <option value="">Choose Manufacture</option>
                                        @foreach ($tire_manufactures as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == $tire_manufacture)>
                                                {{ $item->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <select class="select" name="tire_size">
                                        <option value="">Choose Size</option>
                                        @foreach ($tire_sizes as $item)
                                            <option value="{{ $item->size }}" @selected($item->size == $tire_size)>
                                                {{ $item->size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-6 col-12">
                                <div class="form-group">
                                    <button class="btn btn-filters ms-auto"><img
                                            src="assets/img/icons/search-whites.svg" alt="img"></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Filter -->
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Size</th>
                            <th>Manufacture</th>
                            <th>Pattern</th>
                            <th>Type Pattern</th>
                            <th>OTD</th>
                            <th>Rec. Pressure</th>
                            <th>Price</th>
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
                        <h5 class="modal-title">Forms Size </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Size</label>
                                    <select class="select" name="size" required>
                                        <option>Choose size</option>
                                        @foreach ($size as $item)
                                            <option value="{{ $item->name }}">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tire Pattern</label>
                                    <select class="select" name="tire_pattern_id" required>
                                        <option>Choose pattern</option>
                                        @foreach ($tirepattern as $item)
                                            <option value="{{ $item->id }}">[{{ $item->type_pattern }}]
                                                {{ $item->pattern }} - {{ $item->manufacture->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-6">
                                <div class="form-group">
                                    <label>OTD</label>
                                    <input type="number" min="0" value="0" class="form-control"
                                        name="otd" required>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6 col-6">
                                <div class="form-group">
                                    <label>Rec. Pressure</label>
                                    <input type="number" min="0" value="0" class="form-control"
                                        name="recomended_pressure" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Target Lifetime HM</label>
                                    <input type="number" min="0" value="0" class="form-control"
                                        name="target_lifetime_hm" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Target Lifetime KM</label>
                                    <input type="number" min="0" value="0" class="form-control"
                                        name="target_lifetime_km" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-6">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" class="form-control" name="price">
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
                            data: 'size',
                            name: 'size'
                        },
                        {
                            data: 'manufacture',
                            name: 'manufacture',
                            searchable: false
                        },
                        {
                            data: 'pattern',
                            name: 'pattern',
                            searchable: false
                        },
                        {
                            data: 'type',
                            name: 'type',
                            searchable: false
                        },
                        {
                            data: 'otd',
                            name: 'otd'
                        },
                        {
                            data: 'recomended_pressure',
                            name: 'recomended_pressure'
                        },
                        {
                            data: 'price',
                            name: 'price'
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
                    modal.find('form').attr('action', `{{ route('tiresize.store') }}`)
                } else {
                    var id = button.data('id');
                    $.ajax({
                        method: "GET",
                        url: `{{ route('tiresize.index') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('input[name="size"]').val(response.size).trigger('change');
                        modal.find('select[name="tire_pattern_id"]').val(response.tire_pattern_id).trigger(
                            'change');
                        modal.find('select[name="size"]').val(response.size).trigger(
                            'change');
                        modal.find('input[name="otd"]').val(response.otd).trigger('change');
                        modal.find('input[name="price"]').val(response.price).trigger('change');
                        modal.find('input[name="recomended_pressure"]').val(response.recomended_pressure)
                            .trigger('change');
                        modal.find('input[name="target_lifetime_hm"]').val(response.target_lifetime_hm);
                        modal.find('input[name="target_lifetime_km"]').val(response.target_lifetime_km);
                        modal.find('input[name="_method"]').val('PUT');
                    });
                    modal.find('form').attr('action', `{{ route('tiresize.index') }}/${id}`)
                }
            });
            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
            });
        </script>
    @endpush
</x-app-layout>
