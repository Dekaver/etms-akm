<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>History Tire</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">History</li>
                    <li class="breadcrumb-item active" aria-current="page">Tire Movement</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-top"></div>

            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Serial Number</th>
                            <th>Size</th>
                            <th>Manufacture</th>
                            <th>Pattern</th>
                            <th>Type Pattern</th>
                            <th>Pos</th>
                            <th>Process</th>
                            <th>Status</th>
                            <th>Site</th>
                            <th>Unit</th>
                            <th>Tire HM</th>
                            <th>Tire KM</th>
                            <th>Unit HM</th>
                            <th>Unit KM</th>
                            <th>RTD</th>
                            <th>Driver</th>
                            <th>Damage</th>
                            <th>Price</th>
                            <th>Photo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Photo Preview -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Photo Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="photoPreview" class="img-fluid" alt="Tire Photo">
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/buttons.dataTables.min.css') }}">
    @endpush

    @push('js')
        <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
        <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
        <script type="text/javascript" charset="utf8" src="{{ asset('assets/js/jszip.min.js') }}"></script>
        <script type="text/javascript">
            $(function() {
                var table = $('table.data-table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            text: 'Export Excel',
                            filename: `History Tire Movement ${new Date().getTime()}`
                        },
                        'copy', 'csv'
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('report.historytirescrap') }}",
                    order: [[0, 'desc']], // Sorts by first column (start_date) in descending order
                    columns: [
                        { data: 'start_date', name: 'start_date' },
                        { data: 'tire', name: 'tire' },
                        { data: 'size', name: 'size' },
                        { data: 'manufaktur', name: 'manufaktur' },
                        { data: 'pattern', name: 'pattern' },
                        { data: 'type_pattern', name: 'type_pattern' },
                        { data: 'position', name: 'position' },
                        { data: 'process', name: 'process' },
                        { data: 'status', name: 'status' },
                        { data: 'site', name: 'site' },
                        { data: 'unit', name: 'unit' },
                        { data: 'hm_tire', name: 'hm_tire' },
                        { data: 'km_tire', name: 'km_tire' },
                        { data: 'hm_unit', name: 'hm_unit' },
                        { data: 'km_unit', name: 'km_unit' },
                        { data: 'rtd', name: 'rtd' },
                        { data: 'driver', name: 'driver' },
                        { data: 'damage', name: 'damage' },
                        { data: 'price', name: 'price' },
                        { data: 'photo', name: 'photo', orderable: false, searchable: false }
                    ]
                });
        
                // Photo link handling to show the modal with the image
                $(document).on('click', '.photo-link', function(e) {
                    e.preventDefault();
                    var photoUrl = $(this).data('photo-url');
                    $('#photoPreview').attr('src', photoUrl);
                    $('#photoModal').modal('show');
                });
            });
        </script>        
    @endpush
</x-app-layout>
