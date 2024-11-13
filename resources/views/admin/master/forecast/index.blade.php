<x-app-layout>
    <style>
        .data-table td input,
        .data-table td select {
            min-width: 120px;
            width: 100%;
            padding: 5px 10px;
            box-sizing: border-box;
            font-size: 14px;
        }

        @media (min-width: 768px) {
            .data-table td input,
            .data-table td select {
                min-width: 150px;
            }
        }

        .data-table td input[type="text"] {
            text-align: right;
        }
    </style>

    <div class="page-header">
        <div class="page-title">
            <h4>Forecast</h4>
        </div>
        <div class="page-btn">
            <!-- Button to add a new row at the bottom -->
            <button id="addNewRowBtn" class="btn btn-primary">Add New Forecast</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Tire Size</th>
                            <th>Year</th>
                            <th>January</th>
                            <th>February</th>
                            <th>March</th>
                            <th>April</th>
                            <th>May</th>
                            <th>June</th>
                            <th>July</th>
                            <th>August</th>
                            <th>September</th>
                            <th>October</th>
                            <th>November</th>
                            <th>December</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(function() {
                var tireSizes = @json($size);
                var currentYear = new Date().getFullYear();

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('forecast.index') }}",
                    columns: [
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                        { data: 'tire_size', name: 'tire_size' },
                        { data: 'year', name: 'year' },
                        { data: 'january', name: 'january' },
                        { data: 'february', name: 'february' },
                        { data: 'march', name: 'march' },
                        { data: 'april', name: 'april' },
                        { data: 'may', name: 'may' },
                        { data: 'june', name: 'june' },
                        { data: 'july', name: 'july' },
                        { data: 'august', name: 'august' },
                        { data: 'september', name: 'september' },
                        { data: 'october', name: 'october' },
                        { data: 'november', name: 'november' },
                        { data: 'december', name: 'december' }
                    ]
                });

                // Add a new row for creating a new entry
                $('#addNewRowBtn').click(function() {
                    if ($('#newRow').length === 0) { // Check if new row already exists
                        let newRow = `<tr id="newRow">`;
                        newRow += `<td></td>`; // Static "No" column, non-editable
                        newRow += `<td>
                            <select class="form-control" name="tire_size_id" required>
                                <option value="">Choose Size</option>`;
                        tireSizes.forEach(size => {
                            newRow += `<option value="${size.id}">${size.name}</option>`;
                        });
                        newRow += `</select></td>`;
                        newRow += `<td><input type="number" class="form-control" name="year" value="${currentYear}" required></td>`;

                        // Generate input fields for each month with default value 0
                        ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december']
                        .forEach(month => {
                            newRow += `<td><input type="number" class="form-control" name="${month}" value="0" required></td>`;
                        });

                        newRow += `<td></td>`; // Empty cell for total_forecast
                        newRow += `<td>
                                        <button class="btn btn-success btn-sm" id="saveNewRow">Save</button>
                                        <button class="btn btn-danger btn-sm" id="cancelNewRow">Cancel</button>
                                   </td>`;
                        newRow += `</tr>`;

                        $('.data-table tbody').append(newRow);
                    }
                });

                // Cancel new row creation
                $(document).on('click', '#cancelNewRow', function() {
                    $('#newRow').remove();
                });

                // Save new row data on Enter key or by pressing Save button
                $(document).on('keydown', '#newRow input, #newRow select', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        $('#saveNewRow').click();
                    }
                });

                $(document).on('click', '#saveNewRow', function() {
                    var newData = {};
                    var isValid = true;

                    // Gather data and validate
                    $('#newRow').find('input, select').each(function() {
                        var name = $(this).attr('name');
                        var value = $(this).val();
                        newData[name] = value;

                        // Validation: ensure all fields are filled
                        if (!value) {
                            isValid = false;
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });

                    if (!isValid) {
                        alert('Please fill in all required fields.');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('forecast.store') }}",
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            ...newData
                        },
                        success: function(response) {
                            // alert(response.success);
                            table.ajax.reload();
                            $('#newRow').remove(); // Remove new row after saving
                        },
                        error: function(xhr) {
                            alert("Error adding data: " + xhr.responseJSON.message);
                        }
                    });
                });

                // Enter key save functionality for editing rows
                $(document).on('keydown', 'input, select', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        $(this).closest('tr').find('.save-row').click();
                    }
                });

                $('.data-table').on('click', '.edit-row', function() {
                    var row = $(this).closest('tr');
                    var rowData = table.row(row).data();

                    var tireSizeDropdown = `<select class="form-control" name="tire_size_id">`;
                    tireSizeDropdown += `<option value="">Choose Size</option>`;
                    tireSizes.forEach(size => {
                        var selected = rowData.tire_size_id === size.id ? 'selected' : '';
                        tireSizeDropdown += `<option value="${size.id}" ${selected}>${size.name}</option>`;
                    });
                    tireSizeDropdown += `</select>`;
                    row.find('td').eq(1).html(tireSizeDropdown);

                    row.find('td').each(function(index) {
                        var column = table.column(index).dataSrc();
                        if (column && column !== 'action' && column !== 'tire_size' && column !== 'total_forecast') {
                            var cellValue = $(this).text().replace(/[,.]/g, '');
                            $(this).html(`<input type="text" class="form-control" name="${column}" value="${cellValue}">`);
                        }
                    });

                    row.find('.edit-row').addClass('d-none');
                    row.find('.save-row').removeClass('d-none');
                });

                $('.data-table').on('click', '.save-row', function() {
                    var row = $(this).closest('tr');
                    var rowId = $(this).data('id');
                    var updatedData = {};

                    row.find('input, select').each(function() {
                        var name = $(this).attr('name');
                        var value = $(this).val();
                        updatedData[name] = value.replace(/,/g, '');
                    });

                    $.ajax({
                        url: `{{ route('forecast.update', '') }}/${rowId}`,
                        method: 'PUT',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            ...updatedData
                        },
                        success: function(response) {
                            // alert(response.success);
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            alert("Error updating data: " + xhr.responseJSON.message);
                        }
                    });
                });

                $('.data-table').on('click', '.delete-row', function() {
                    var rowId = $(this).data('id');
                    var actionUrl = $(this).data('action');

                    if (confirm("Are you sure you want to delete this record?")) {
                        $.ajax({
                            url: actionUrl,
                            method: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                // alert(response.success);
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                alert("Error deleting data: " + xhr.responseJSON.message);
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
