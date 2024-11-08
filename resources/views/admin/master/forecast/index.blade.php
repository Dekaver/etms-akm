<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>Forecast</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Forecast</li>
                </ol>
            </nav>
        </div>
        <div class="page-btn">
            <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#form-modal" data-post="new"><img
                    src="assets/img/icons/plus.svg" alt="img" class="me-1">Add Forecast</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tire Size</th>
                            <th>Year</th>
                            <th>Total Forecast</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Add/Edit Modal -->
    <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            @csrf
            @method('PUT')
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Forecast</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tire Size</label>
                                    <select class="form-control" name="tire_size_id">
                                        <option value="">Choose Size</option>
                                        @foreach ($size as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Year<span class="manitory">*</span></label>
                                    <input type="number" class="form-control" name="year" required>
                                </div>
                            </div>
                            @foreach (['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'] as $month)
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>{{ ucfirst($month) }} <span class="manitory">*</span></label>
                                        <input type="text" step="0.01" class="form-control number-format"
                                            name="{{ $month }}" required>
                                    </div>
                                </div>
                            @endforeach

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
                    ajax: "{{ route('forecast.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'tire_size',
                            name: 'tire_size'
                        },
                        {
                            data: 'year',
                            name: 'year'
                        },
                        {
                            data: 'total_forecast',
                            name: 'total_forecast'
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
                var button = $(event.relatedTarget);
                var post = button.data('post');
                var modal = $(this);

                if (post == 'new') {
                    modal.find('input[name="_method"]').val('POST');
                    modal.find('form').attr('action', `{{ route('forecast.store') }}`);
                } else {
                    var id = button.data('id');
                    $.ajax({
                        method: "GET",
                        url: `{{ url('forecast') }}/${id}/edit`
                    }).done(function(response) {
                        modal.find('input[name="year"]').val(response.year);
                        modal.find('select[name="tire_size_id"]').val(response.tire_size_id).trigger("change");
                        @foreach (['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'] as $month)
                            modal.find('input[name="{{ $month }}"]').val(formatNumber(response
                                .{{ $month }}));
                        @endforeach
                        modal.find('input[name="_method"]').val('PUT');
                    });
                    modal.find('form').attr('action', `{{ url('forecast') }}/${id}`);
                }
            });

            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
            });

            // Function to format number with thousand separators
            function formatNumber(value) {
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Add 'input' event listener to format numbers as user types
            $(document).on('input', '.number-format', function(e) {
                // Remove non-numeric characters (except for decimal point)
                let value = $(this).val().replace(/[^0-9.]/g, '');
                $(this).val(formatNumber(value));
            });

            // Select all text when input is focused
            $(document).on('focus', '.number-format', function() {
                $(this).select();
            });
        </script>
    @endpush


</x-app-layout>
