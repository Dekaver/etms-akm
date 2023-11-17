<x-app-layout>
    @push('css')
        <style>
            .graphic-container {
                min-height: 380px;
                max-height: 380px;
                overflow-y: auto;
                overflow-x: hidden;
            }
        </style>
        {{-- <div class="page-header">
            <div class="page-title">
                <h4>{{ strtoupper(auth()->user()->company->name ?? '') }} - {{ auth()->user()->site->name ?? '' }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ auth()->user()->name }}</a></li>
                    </ol>
                </nav>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-lg-5 col-sm-12 col-12">
                <div class="card" style="background: #0d4781!important;">
                    <div class="card-body">
                        <div class="row rounded-3 w-100">
                            <div class="col dash-count px-2 justify-content-start align-items-center">
                                <div class="dash-imgs me-2">
                                    <img src="assets/img/dashboard/icon3.png" alt="">
                                </div>
                                <div class="dash-counts">
                                    <h4>{{ (int) $stok_new + (int) $stok_spare + (int) $stok_repair }}</h4>
                                    <h5>TIRE INVENTORY</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon1.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $stok_new }}</h4>
                                            <h5>NEW</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon3.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $stok_spare }}</h4>
                                            <h5>SPARE</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon4.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $stok_repair }}</h4>
                                            <h5>REPAIR</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12 col-12">
                <div class="card" style="background: #198148!important;">
                    <div class="card-body">
                        <div class="row justify-content-evenly px-2 rounded-3 w-100">
                            <div class="dash-count px-2 justify-content-start align-items-center col">
                                <div class="dash-imgs me-2">
                                    <img src="assets/img/dashboard/icon5.png" alt="">
                                </div>
                                <div class="dash-counts">
                                    <h4>{{ (int) $install_new + (int) $install_spare + (int) $install_repair }}</h4>
                                    <h5>TIRE INSTALL</h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon1.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $install_new }}</h4>
                                            <h5>NEW</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon3.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $install_spare }}</h4>
                                            <h5>SPARE</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="dash-count px-2 justify-content-end align-items-end">
                                        <div class="dash-imgs me-2" style="width: 40px">
                                            <img src="assets/img/dashboard/icon4.png" alt="">
                                        </div>
                                        <div class="dash-counts" style="width: 100px; text-align: right">
                                            <h4>{{ (int) $install_repair }}</h4>
                                            <h5>REPAIR</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-12 col-12">
                <div class="card" style="background: #e07218!important;margin-bottom: 11px">
                    <div class="card-body">
                        <div class="row justify-content-evenly px-2 rounded-3 w-100">
                            <div class="dash-count px-2 justify-content-start align-items-center col">
                                <div class="dash-imgs me-2" style="width: 40px">
                                    <img src="assets/img/dashboard/icon2.png" alt="">
                                </div>
                                <div class="dash-counts">
                                    <h4>{{ (int) $repairing }}</h4>
                                    <h5>TIRE REPAIRING</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="background: #ad2525!important;">
                    <div class="card-body">
                        <div class="row justify-content-evenly px-2 rounded-3 w-100">
                            <div class="dash-count px-2 justify-content-start align-items-center col">
                                <div class="dash-imgs me-2" style="width: 40px">
                                    <img src="assets/img/dashboard/icon6.png" alt="">
                                </div>
                                <div class="dash-counts">
                                    <h4>{{ (int) $scrap }}</h4>
                                    <h5>TIRE SCRAP</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-12">
                <div class="card o-hidden">
                    <div class="card-header pb-0">
                        <h5>Tire Inventory
                            <a class="float-end" href="#" onclick="toggleFullScreen(this)">
                                <i data-feather="maximize"></i>
                            </a>
                        </h5>
                    </div>
                    <div class="bar-chart-widget">
                        <div class="bottom-content card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div id="chart-tire-inventory"
                                        data-url="{{ str_replace(Request::url(), url('grafik-tire-inventory'), Request::fullUrl()) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @push('js')
            <script src="{{ asset('assets/view/grafik.js') }}"></script>

            <script>
                function toggleFullScreen(e) {

                    elem = e.parentElement.parentElement.parentElement;
                    // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
                    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document
                            .msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document
                            .mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !==
                            undefined && !document.webkitIsFullScreen)) {
                        if (elem.requestFullScreen) {
                            elem.requestFullScreen();
                        } else if (elem.mozRequestFullScreen) {
                            elem.mozRequestFullScreen();
                        } else if (elem.webkitRequestFullScreen) {
                            elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                        } else if (elem.msRequestFullscreen) {
                            elem.msRequestFullscreen();
                        }
                    } else {
                        if (document.cancelFullScreen) {
                            document.cancelFullScreen();
                        } else if (document.mozCancelFullScreen) {
                            document.mozCancelFullScreen();
                        } else if (document.webkitCancelFullScreen) {
                            document.webkitCancelFullScreen();
                        } else if (document.msExitFullscreen) {
                            document.msExitFullscreen();
                        }
                    }
                }
            </script>
        @endpush

    </x-app-layout>
