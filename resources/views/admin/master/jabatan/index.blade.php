<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Jabatan</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jabatan</li>
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
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jabatan</th>
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
                        <h5 class="modal-title">Add Jabatan </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Jabatan<span class="manitory">*</span></label>
                                    <input type="text" class="form-control" name="jabatan" required>
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
                    ajax: "{{ route('jabatan.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'jabatan',
                            name: 'jabatan'
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
                    modal.find('form').attr('action', `{{ route('jabatan.store') }}`)
                } else {
                    var id = button.data('id');
                    $.ajax({
                        method: "GET",
                        url: `{{ route('jabatan.index') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('input[name="jabatan"]').val(response.jabatan);
                        modal.find('input[name="_method"]').val('PUT');
                    });
                    modal.find('form').attr('action', `{{ route('jabatan.index') }}/${id}`)
                }
            });

            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
            });
        </script>
    @endpush
</x-app-layout>
