<x-app-layout>
    <div class="page-header">
        <div class="page-title">
            <h4>History Tire</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">History</li>
                    <li class="breadcrumb-item active">Tire</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Serial Number</th>
                            <th>Position</th>
                            <th>Site</th>
                            <th>Unit</th>
                            <th>HM (Hours)</th>
                            <th>KM</th>
                            <th>RTD</th>
                            <th>Pressure</th>
                            <th>Tube</th>
                            <th>Flap</th>
                            <th>Rim</th>
                            <th>T. Pentil</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @push('js')
        <script type="text/javascript">
            $(document).ready(function() {
                $('table.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('historytiremovement.tire', $tire->id) }}",
                    columns: [
                        { data: 'date', name: 'date' },
                        { data: 'tire', name: 'tire' },
                        { data: 'position', name: 'position' },
                        { data: 'site', name: 'site' },
                        { data: 'unit', name: 'unit' },
                        { data: 'lifetime_hm', name: 'lifetime_hm', render: $.fn.dataTable.render.number(',', '.', 0, '') },
                        { data: 'lifetime_km', name: 'lifetime_km', render: $.fn.dataTable.render.number(',', '.', 0, '') },
                        { data: 'rtd', name: 'rtd' },
                        { data: 'pressure', name: 'pressure' },
                        { data: 'tube', name: 'tube' },
                        { data: 'flap', name: 'flap' },
                        { data: 'rim', name: 'rim' },
                        { data: 'tPentil', name: 'tPentil', orderable: false, searchable: false },
                        { data: 'remark', name: 'remark' }
                    ],
                    order: [[0, 'desc']],
                    language: {
                        processing: "Loading...",
                        search: "Filter records:",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoFiltered: "(filtered from _MAX_ total entries)"
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
