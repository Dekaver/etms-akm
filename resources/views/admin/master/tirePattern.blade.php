<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Tire Pattern</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data Tire</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Pattern</li>
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
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Manufacture</option>
                                            <option>AELOUS</option>
                                            <option>ADVANCE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <select class="select">
                                            <option>Choose Pattern</option>
                                            <option>GL665A</option>
                                            <option>GL690A</option>
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
                            <th>Tire Manufacture</th>
                            <th>Pattern</th>
                            <th>Type Pattern</th>
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
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Pattern </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group ">
                                    <label>Tire Manufacture</label>
                                    <select class="select" name="tire_manufacture_id">
                                        <option>Choose Manufacture</option>
                                        @foreach ($tiremanufacture as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Pattern<span class="manitory">*</span></label>
                                    <input type="text" name="pattern">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <label>Type Pattern</label>
                                    <select class="select" name="type_pattern">
                                        <option>Choose Manufacture</option>
                                        <option> Lug</option>
                                        <option> Mix</option>
                                        <option> Rib</option>
                                    </select>
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
                    ajax: "{{ route('tirepattern.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'manufacture_name',
                            name: 'manufacture_name'
                        },
                        {
                            data: 'pattern',
                            name: 'pattern'
                        },
                        {
                            data: 'type_pattern',
                            name: 'type_pattern'
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
                    modal.find('form').attr('action', `{{ route('tirepattern.store') }}`)
                } else {
                    var id = button.data('id');
                    $.ajax({
                        method: "GET",
                        url: `{{ route('tirepattern.index') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('input[name="pattern"]').val(response.pattern);
                        modal.find('select[name="type_pattern"]').val(response.type_pattern).trigger('change');
                        modal.find('select[name="tire_manufacture_id"]').val(response.tire_manufacture_id)
                            .trigger('change');
                        console.log(response.tire_manufacture_id);
                        modal.find('input[name="_method"]').val('PUT');
                    });
                    modal.find('form').attr('action', `{{ route('tirepattern.index') }}/${id}`)
                }
            });
            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
                $(this).find('select[name="type_pattern"]').trigger("change")
                $(this).find('select[name="tire_manufacture_id"]').trigger("change")
            });
        </script>
    @endpush
</x-app-layout>
