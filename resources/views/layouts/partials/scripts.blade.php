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

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Custom JS -->
<script src="{{ asset('assets/js/script.js') }}"></script>

<script>
    @if (session()->has('success'))
        toastr.success(
            "{{ session('success') }}",
            "Success", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0
            }
        )
    @elseif (session()->has('info'))
        toastr.info(
            "{{ session('info') }}",
            "Info", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0
            }
        )
    @elseif (session()->has('warning'))
        toastr.warning(
            "{{ session('warning') }}",
            "Warning", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0
            }
        )
    @elseif (session()->has('error'))
        toastr.error(
            "{{ session('error') }}",
            "Error", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0
            }
        )
    @elseif ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error(
                "{{ $error }}",
                "Error", {
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    timeOut: 5e3,
                    closeButton: !0,
                    tapToDismiss: !0,
                    progressBar: !0
                }
            )
        @endforeach
    @endif
</script>
@stack('js')
