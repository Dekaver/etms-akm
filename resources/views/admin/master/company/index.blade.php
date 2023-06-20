<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/plugins/twitter-bootstrap-wizard/form-wizard.css') }}">
    @endpush
    <div class="page-header">
        <div class="page-title">
            <h4>Customer</h4>
            <!-- <h6>Manage your products</h6> -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Data </a></li>
                    <li class="breadcrumb-item active" aria-current="page">Customer</li>
                </ol>
            </nav>
        </div>
        <!-- <div class="page-btn">
            <a href="addproduct.html" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add New Product</a>
        </div> -->
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
            <!-- /Filter -->
            <div class="table-responsive">
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Initial</th>
                            <th>Email</th>
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
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Company </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="progrss-wizard" class="twitter-bs-wizard">
                            <ul class="twitter-bs-wizard-nav nav nav-pills nav-justified">
                                <li class="nav-item">
                                    <a href="#progress-seller-details" class="nav-link" data-toggle="tab">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="User Details">
                                            <i class="fas fa-map-pin"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#progress-company-document" class="nav-link" data-toggle="tab">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Address Detail">
                                            <i class="far fa-user"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#site-page" class="nav-link" data-toggle="tab">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Address Detail">
                                            <i class="far fa-user"></i>
                                        </div>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#progress-bank-detail" class="nav-link" data-toggle="tab">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Payment Details">
                                            <i class="fas fa-credit-card"></i>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <!-- wizard-nav -->

                            <div id="bar" class="progress mt-4">
                                <div
                                    class="progress-bar bg-success progress-bar-striped progress-sm progress-bar-animated">
                                </div>
                            </div>
                            <div class="tab-content twitter-bs-wizard-tab-content">
                                <div class="tab-pane" id="progress-seller-details">
                                    <div class="mb-4">
                                        <h5>Customer Details</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="progresspill-firstname-input">Full Name<span
                                                        class="manitory">*</span></label>
                                                <input type="text" class="form-control" name="company_name" required
                                                    id="progresspill-firstname-input">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="progresspill-lastname-input">Initial<span
                                                        class="manitory">*</span></label>
                                                <input type="text" class="form-control" name="initial" required
                                                    id="progresspill-lastname-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="progresspill-phoneno-input">Phone</label>
                                                <input type="text" class="form-control" name="phone"
                                                    id="progresspill-phoneno-input">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="progresspill-email-input">Email</label>
                                                <input type="email" class="form-control" name="email" required
                                                    id="progresspill-email-input">
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager wizard twitter-bs-wizard-pager-link">
                                        <li class="next">
                                            <a href="javascript: void(0);" class="btn btn-primary"
                                                onclick="this.get">Next <i class="bx bx-chevron-right ms-1"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-pane" id="progress-company-document">
                                    <div>
                                        <div class="mb-4">
                                            <h5>Account Admin</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="progresspill-firstname-input">Name<span
                                                            class="manitory">*</span></label>
                                                    <input type="text" class="form-control" name="name"
                                                        required id="progresspill-firstname-input">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="progresspill-lastname-input">Email<span
                                                            class="manitory">*</span></label>
                                                    <input type="text" class="form-control" name="email"
                                                        required id="progresspill-lastname-input">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="progresspill-phoneno-input">Password</label>
                                                    <input type="password" class="form-control" name="password"
                                                        id="progresspill-phoneno-input">
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="pager wizard twitter-bs-wizard-pager-link">
                                            <li class="previous"><a href="javascript: void(0);"
                                                    class="btn btn-primary"><i class="bx bx-chevron-left me-1"></i>
                                                    Previous</a></li>
                                            <li class="next"><a href="javascript: void(0);"
                                                    class="btn btn-primary">Next <i
                                                        class="bx bx-chevron-right ms-1"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane" id="site-page">
                                    <div>
                                        <div class="mb-4">
                                            <h5>Site</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="progresspill-firstname-input">Name<span
                                                            class="manitory">*</span></label>
                                                    <input type="text" class="form-control" name="site_name"
                                                        required id="progresspill-firstname-input">
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="pager wizard twitter-bs-wizard-pager-link">
                                            <li class="previous"><a href="javascript: void(0);"
                                                    class="btn btn-primary"><i class="bx bx-chevron-left me-1"></i>
                                                    Previous</a></li>
                                            <li class="next"><a href="javascript: void(0);"
                                                    class="btn btn-primary">Next <i
                                                        class="bx bx-chevron-right ms-1"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane" id="progress-bank-detail">
                                    <div>
                                        <div class="mb-4">
                                            <h5>Data</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-check">
                                                    <label class="inputcheck">Empty Data
                                                        <input type="checkbox" name="empty_data">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-check">
                                                    <label class="inputcheck">Data Demo
                                                        <input type="checkbox" name="data_demo" readonly>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-check">
                                                    <label class="inputcheck">Clone from
                                                        <input type="checkbox" name="clone_from">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-1"></div>
                                                    <div class="col-11">
                                                        <div class="mb-3">
                                                            <label class="form-label">Customer</label>
                                                            <select class="form-select" name="customer">
                                                                <option value="">Select Customer</option>
                                                                @foreach ($companies as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-1"></div>
                                                    <div class="col-11">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-check">
                                                                    <label class="inputcheck">Master Only
                                                                        <input type="checkbox" name="master_only">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-check">
                                                                    <label class="inputcheck">All Data
                                                                        <input type="checkbox" name="all_data"
                                                                            readonly>
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <ul class="pager wizard twitter-bs-wizard-pager-link">
                                            <li class="previous"><a href="javascript: void(0);"
                                                    class="btn btn-primary"><i class="bx bx-chevron-left me-1"></i>
                                                    Previous</a></li>
                                            <li class="float-end">
                                                <button class="btn btn-primary" type="submit">Save
                                                    Changes</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- update Modal -->
    <div class="modal fade" id="form-update-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <form method="POST">
            <div class="modal-dialog modal-dialog-centered" role="document">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Company </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-group">
                                    <label>Nama<span class="manitory">*</span></label>
                                    <input type="text" name="name" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label>Initial<span class="manitory">*</span></label>
                                    <input type="text" name="initial" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Email<span class="manitory">*</span></label>
                                    <input type="text" name="email" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Logo</label>
                                    <input type="file" name="logo" accept=".png">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" name="state">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="city">
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label>address</label>
                                    <input type="text" name="address">
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
        <!-- Wizard JS -->
        <script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/prettify.js') }}"></script>
        <script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/form-wizard.js') }}"></script>
        <script type="text/javascript">
            $(function() {
                var table = $('table.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('company.index') }}",
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
                            data: 'initial',
                            name: 'initial'
                        },
                        {
                            data: 'email',
                            name: 'email'
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

            $('#form-update-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var post = button.data('post');
                var modal = $(this)

                var id = button.data('id');
                $.ajax({
                    method: "GET",
                    url: `{{ route('company.index') }}/${id}/edit`
                }).done(function(response) {
                    modal.find('input[name="name"]').val(response.name);
                    modal.find('input[name="initial"]').val(response.initial);
                    modal.find('input[name="email"]').val(response.email);
                    modal.find('input[name="city"]').val(response.city);
                    modal.find('input[name="state"]').val(response.state);
                    modal.find('input[name="address"]').val(response.address);
                    modal.find('input[name="_method"]').val('PUT');
                });
                modal.find('form').attr('action', `{{ route('company.index') }}/${id}`)
            });
            $('#form-update-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
            });

            $('#form-modal').on('hide.bs.modal', function(event) {
                $(this).find('form')[0].reset();
            });
        </script>
    @endpush

</x-app-layout>
