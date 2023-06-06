<!-- /Main Wrapper -->

<!-- jQuery -->
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ asset('assets/js/feather.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

<!-- Datatable JS -->
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>


<script src="assets/js/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>

<!-- Select2 JS -->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

<!-- Sweetalert 2 -->
<script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>

<!-- Mask JS -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('assets/js/script.js') }}"></script>

<script>
    @if (session()->has('success'))
        toastr.success(
            "<strong>Success</strong> {{ session('success') }}",
            "Progress Bar", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0
            }
        )
    @elseif (session()->has('info'))
        toastr.info(
            "<strong>Info</strong> {{ session('info') }}",
            "Progress Bar", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0
            }
        )
    @elseif (session()->has('warning'))
        toastr.warning(
            "<strong>Warning</strong> {{ session('warning') }}",
            "Progress Bar", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0
            }
        )
    @elseif (session()->has('error'))
        toastr.error(
            "<strong>Error</strong> {{ session('error') }}",
            "Progress Bar", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0
            }
        )
    @endif
</script>
@stack('js')
