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
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Site</th>
                            <th>Tire Size</th>
                            <th>manufacture</th>
                            <th>Target KM</th>
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
                        <h5 class="modal-title">Add Tire Target KM </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Site<span class="manitory">*</span></label>
                                    <select name="site_id" class="form-select">
                                        <option value="">-- Select --</option>
                                        @foreach ($sites  as $item)
                                            <option value="{{ $item->id }}" @selected((auth()->user()->site->id ?? null) == $item->id)>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tire Size<span class="manitory">*</span></label>
                                    <select name="tire_size_id" class="form-select">
                                        <option value="">-- Select --</option>
                                        @foreach ($tire_sizes as $item)
                                            <option value="{{ $item->id }}" data-manufacture="{{ $item->tire_pattern->manufacture->name }}">{{ $item->size }} - {{ $item->tire_pattern->manufacture->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tire Manufacture<span class="manitory">*</span></label>
                                    <input type="text" class="form-control" name="manufacture" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Tire Target KM<span class="manitory">*</span></label>
                                    <input type="number" class="form-control" name="rtd_target_km" max="99999" required>
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
                    ajax: "{{ route('tiretargetkm.index') }}",
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
                            data: 'tire_size',
                            name: 'tire_size'
                        },
                        {
                            data: 'manufacture',
                            name: 'manufacture'
                        },
                        {
                            data: 'rtd_target_km',
                            name: 'rtd_target_km'
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
                    modal.find('form').attr('action', `{{ route('tiretargetkm.store') }}`)
                } else {
                    var id = button.data('id');
                    $.ajax({
                        method: "GET",
                        url: `{{ route('tiretargetkm.index') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('select[name="site_id"]').val(response.site_id);
                        modal.find('select[name="tire_size_id"]').val(response.tire_size_id).trigger("change");
                        modal.find('input[name="rtd_target_km"]').val(response.rtd_target_km);
                        modal.find('input[name="_method"]').val('PUT');
                    });
                    modal.find('form').attr('action', `{{ route('tiretargetkm.index') }}/${id}`)
                }
            });
            $("#form-modal").find('select[name="tire_size_id"]').change(function () {
                var value = $(this).find("option:selected").data("manufacture");
                $("#form-modal").find('input[name="manufacture"]').val(value);
            });

            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
            });
        </script>
    @endpush
</x-app-layout>
