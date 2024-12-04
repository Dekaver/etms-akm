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


<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>

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
    var tire;
    var position;

    function setDynamicGradientColor(id, percentage) {
        const gradientContainer = document.getElementById(id);
        const hue = (parseFloat(percentage) / 100) * 120; // 120 is the hue for green
        gradientContainer.style.backgroundColor = `hsl(${percentage}, 100%, 50%)`;
    }

    var containerBars = document.querySelectorAll('.container-tooltip');

    containerBars.forEach(function(containerBar) {
        var tooltipTire = containerBar.querySelector('.tooltip-tire');

        if (tooltipTire) {
            containerBar.addEventListener('mousemove', function(e) {
                console.log(e);
                var x = e.clientX;
                var y = e.clientY;

                tooltipTire.style.left = x + 'px';
                tooltipTire.style.top = y + 'px';
            });
        }
    });

    // Only allow input of numbers, navigation keys, and modifier keys
    function keyDown(event) {
        return (
            // Allow Ctrl + any key
            event.ctrlKey ||
            // Allow Alt + any key
            event.altKey ||
            (
                // Allow number keys 0-9
                47 < event.keyCode &&
                event.keyCode < 58 &&
                // Don't allow shift key to be pressed
                event.shiftKey == false
            ) ||
            (
                // Allow numpad keys 0-9
                95 < event.keyCode &&
                event.keyCode < 106
            ) ||
            (
                // Allow delete key
                event.keyCode == 8
            ) || (
                // Allow tab key
                event.keyCode == 9
            ) ||
            (
                // Allow home, end, left, right, up, down
                event.keyCode > 34 &&
                event.keyCode < 40
            ) || (
                // Allow dot key
                event.keyCode == 46
            )
        )
    }

    function fNumber(angka) {
        var number_string = typeof angka === 'number' ? angka.toString() : parseFloat(angka && angka.replace(/[^,\d]/g,
                '')).toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }
</script>
@stack('js')
