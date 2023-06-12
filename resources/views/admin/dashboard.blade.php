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
        <div class="page-header">
            <div class="page-title">
                <h4>Dashboard {{ auth()->user()->company->name ?? '' }} - {{ auth()->user()->site->name ?? '' }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ auth()->user()->name }}</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-imgs">
                        <i data-feather="user"></i>
                    </div>
                    <div class="dash-counts">
                        <h4>100</h4>
                        <h5>New Stock</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-12 d-flex">
                <div class="dash-count das1">
                    <div class="dash-imgs">
                        <i data-feather="user-check"></i>
                    </div>
                    <div class="dash-counts">
                        <h4>100</h4>
                        <h5>New Install</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-12 d-flex">
                <div class="dash-count das2">
                    <div class="dash-imgs">
                        <i data-feather="file-text"></i>
                    </div>
                    <div class="dash-counts">
                        <h4>100</h4>
                        <h5>Tyre Spare</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-12 d-flex">
                <div class="dash-count das3">
                    <div class="dash-imgs">
                        <i data-feather="file"></i>
                    </div>
                    <div class="dash-counts">
                        <h4>105</h4>
                        <h5>Repairing</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-12 d-flex">
                <div class="dash-count das4">
                    <div class="dash-imgs">
                        <i data-feather="file"></i>
                    </div>
                    <div class="dash-counts">
                        <h4>105</h4>
                        <h5>Running</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg col-sm-6 col-12 d-flex">
                <div class="dash-count das3">
                    <div class="dash-imgs">
                        <i data-feather="file"></i>
                    </div>
                    <div class="dash-counts">
                        <h4>105</h4>
                        <h5>Scrap</h5>
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
