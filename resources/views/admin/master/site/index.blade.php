<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Site</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Site</li>
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
            {{-- <div class="table-top">
                <div class="search-set">
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
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Site</th>
                            <th>Jarak Hauling</th>
                            <th>Rit Per Hari</th>
                            <th>Total Jarak</th>
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
                        <h5 class="modal-title">Add Site </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Name<span class="manitory">*</span></label>
                                    <input type="text" name="name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Jarak Hauling (KM)<span class="manitory">*</span></label>
                                    <input type="number" class="form-control" name="jarak_hauling">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Rit per hari<span class="manitory">*</span></label>
                                    <input type="number" class="form-control" name="rit_per_hari">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Total jarak KM<span class="manitory">*</span></label>
                                    <input type="number" class="form-control" name="total_jarak" readonly>
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
        <script>
            $(function() {
                var table = $('table.data-table').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: "{{ route('site.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'jarak_hauling',
                            name: 'jarak_hauling'
                        },
                        {
                            data: 'rit_per_hari',
                            name: 'rit_per_hari'
                        },
                        {
                            data: 'total_jarak',
                            name: 'total_jarak'
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
                    modal.find('form').attr('action', `{{ route('site.store') }}`)
                } else {
                    var id = button.data('id');
                    $.ajax({
                        method: "GET",
                        url: `{{ route('site.index') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('input[name="name"]').val(response.name);
                        modal.find('input[name="jarak_hauling"]').val(response.jarak_hauling);
                        modal.find('input[name="rit_per_hari"]').val(response.rit_per_hari);
                        modal.find('input[name="total_jarak"]').val(response.total_jarak);
                        modal.find('input[name="_method"]').val('PUT');
                    });
                    modal.find('form').attr('action', `{{ route('site.index') }}/${id}`)
                }
            });
            $("#form-modal").find('input[name="jarak_hauling"]').change(total_jarak);
            $("#form-modal").find('input[name="rit_per_hari"]').change(total_jarak);

            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
            });
            function total_jarak(){
                var jarak_hauling = $('#form-modal').find('input[name="jarak_hauling"]').val();
                var rit_per_hari = $('#form-modal').find('input[name="rit_per_hari"]').val();
                var total_jarak = jarak_hauling * rit_per_hari;
                $('#form-modal').find('input[name="total_jarak"]').val(total_jarak);
            }
        </script>
    @endpush
</x-app-layout>
