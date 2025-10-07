<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Tire Damage</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data Tire</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Damage</li>
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
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="assets/img/icons/excel.svg" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="assets/img/icons/printer.svg" alt="img"></a>
                        </li>
                    </ul>
                </div>
            </div> --}}
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Damage</th>
                            <th>Cause</th>
                            <th>Rating</th>
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
                        <h5 class="modal-title">Add Damage </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Damage</label>
                                    <input type="text" name="damage" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group ">
                                    <label>Cause</label>
                                    <select class="select-with-input form-control" name="cause" required>
                                        <option>Choose Cause</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Rating</label>
                                    <input type="text" name="rating" required>
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
                    ajax: "{{ route('tiredamage.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'damage',
                            name: 'damage'
                        },
                        {
                            data: 'cause',
                            name: 'cause'
                        },
                        {
                            data: 'rating',
                            name: 'rating'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
                $('#form-modal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var post = button.data('post');
                    var modal = $(this)
                    let causes = ["MAINTENANCE", "NORMAL", "OPERATIONAL"];
                    causes.forEach(cause => {
                        modal.find('select[name="cause"]').append($('<option>', {
                            value: cause.toUpperCase(),
                            text: cause.toUpperCase()
                        }))
                        console.log(modal.find('select[name="cause"]'));
                    });

                    if (post == 'new') {
                        modal.find('input[name="_method"]').val('POST');
                        modal.find('form').attr('action', `{{ route('tiredamage.store') }}`)
                    } else {
                        var id = button.data('id');
                        $.ajax({
                            method: "GET",
                            url: `{{ route('tiredamage.index') }}/${id}/edit`
                        }).done(function(response) {
                            modal.find('input[name="damage"]').val(response.damage).trigger('change');
                            modal.find('select[name="cause"]').val(response.cause).trigger('change');
                            modal.find('input[name="rating"]').val(response.rating).trigger('change');
                            modal.find('input[name="_method"]').val('PUT');
                        });
                        modal.find('form').attr('action', `{{ route('tiredamage.index') }}/${id}`)
                    }
                });
                $('#form-modal').on('hide.bs.modal', function(event) {
                    $(this).find('form')[0].reset();
                });
            });



            if ($('.select-with-input').length > 0) {
                $('.select-with-input').select2({
                    tags: true,
                    dropdownParent: $("#form-modal"),
                    // minimumResultsForSearch: 5,
                    width: '100%'
                });
            }
        </script>
    @endpush
</x-app-layout>
