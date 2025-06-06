<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu h-100">
            <ul class="h-100">
                <li class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
                    <a href="/dashboard"><img src="{{ asset('assets/img/icons/dashboard.svg') }}" alt="img"><span>
                            Dashboard</span> </a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/purchase1.svg') }}"
                            alt="img"><span>
                            Grafik</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @can('GRAFIK')
                            <li><a href="/tire-performance"
                                    class="{{ Request::routeIs('tire-performance') ? 'active' : '' }}">Tire Performance</a>
                            </li>
                            <li><a href="/tire-performance-scrap"
                                    class="{{ Request::routeIs('tire-performance-scrap') ? 'active' : '' }}">Tire Scrap
                                    Performance</a>
                            </li>
                            <li><a href="/tire-scrap" class="{{ Request::routeIs('tire-scrap') ? 'active' : '' }}">Tire
                                    Scrap</a></li>
                            <li><a href="/tire-cause-damage"
                                    class="{{ Request::routeIs('tire-cause-damage') ? 'active' : '' }}">Tire
                                    Cause Damage</a></li>
                        @endcan


                        @can('HISTORY_TIRE_MOVEMENT')
                            <li><a href="/history-tire-consumption/monthly"
                                    class="{{ Request::routeIs('tireconsumption') ? 'active' : '' }}">Monthly Tire
                                    Consumption</a></li>
                            <li><a href="/history-tire-consumption/annual"
                                    class="{{ Request::routeIs('tireconsumption.annual') ? 'active' : '' }}">Annual Tire
                                    Consumption</a></li>
                            <li><a href="/report-tire-rtd-per-unit"
                                    class="{{ Request::routeIs('report.tirertdperunit') ? 'active' : '' }}">Report Tire
                                    RTD Per UNIT</a></li>
                            <li><a href="/historytirerepair"
                                    class="{{ Request::routeIs('historytirerepair.*') ? 'active' : '' }}">Report After Tire
                                    Repair</a></li>
                            <li><a href="/tire-new-movement"
                                    class="{{ Request::routeIs('tire-new-movement') ? 'active' : '' }}">
                                    Report Tire Ussage</a></li>
                            <li><a href="/lead-time-job"
                                    class="{{ Request::routeIs('lead-time-job') ? 'active' : '' }}">
                                    Report Lead Time Job</a></li>
                        @endcan
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/expense1.svg') }}"
                            alt="img"><span>
                            Data Tire</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @can('TIRE_MANUFACTURE')
                            <li><a href="/tiremanufacture"
                                    class="{{ Request::routeIs('tiremanufacture.*') ? 'active' : '' }}">
                                    Tire Manufacture
                                </a></li>
                        @endcan
                        @can('TIRE_PATTERN')
                            <li><a href="/tirepattern" class="{{ Request::routeIs('tirepattern.*') ? 'active' : '' }}">Tire
                                    Pattern</a></li>
                        @endcan
                        @can('TIRE_SIZE')
                            <li><a href="/size" class="{{ Request::routeIs('size.*') ? 'active' : '' }}">
                                    Master Tire Size</a></li>
                        @endcan
                        @can('TIRE_SIZE')
                            <li><a href="/tiresize" class="{{ Request::routeIs('tiresize.*') ? 'active' : '' }}">Tire
                                    Size</a></li>
                        @endcan
                        @can('TIRE_COMPOUND')
                            <li><a href="/tirecompound"
                                    class="{{ Request::routeIs('tirecompound.*') ? 'active' : '' }}">Tire Compound</a></li>
                        @endcan
                        @can('TIRE_STATUS')
                            <li><a href="/tirestatus" class="{{ Request::routeIs('tirestatus.*') ? 'active' : '' }}">Tire
                                    Status</a></li>
                        @endcan
                        @can('TIRE_DAMAGE')
                            <li><a href="/tiredamage" class="{{ Request::routeIs('tiredamage.*') ? 'active' : '' }}">Tire
                                    Damage</a></li>
                        @endcan
                        @can('TIRE_MASTER')
                            <li><a href="/tiremaster" class="{{ Request::routeIs('tiremaster.*') ? 'active' : '' }}">Tire
                                    Data Master</a></li>
                        @endcan
                        @can('LAST_TIRE_MOVEMENT')
                            <li><a href="/last-tire-movement" class="{{ Request::routeIs('lastTireMovement.*') ? 'active' : '' }}">Last Tire
                                    Movement</a></li>
                        @endcan
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/quotation1.svg') }}"
                            alt="img"><span>
                            Data</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @can('SITE')
                            <li><a href="/site" class="{{ Request::routeIs('site.*') ? 'active' : '' }}">Site</a>
                            </li>
                        @endcan
                        @can('TIRE_TARGETKM')
                            <li><a href="/tiretargetkm"
                                    class="{{ Request::routeIs('tiretargetkm.*') ? 'active' : '' }}">Target KM</a>
                            </li>
                        @endcan

                        @can('UNIT_STATUS')
                            <li><a href="/unitstatus" class="{{ Request::routeIs('unitstatus.*') ? 'active' : '' }}">Unit
                                    Status</a>
                            </li>
                        @endcan
                        @can('UNIT_MODEL')
                            <li><a href="/unitmodel" class="{{ Request::routeIs('unitmodel.*') ? 'active' : '' }}">Unit
                                    Model</a>
                            </li>
                        @endcan
                        @can('UNIT')
                            <li><a href="/unit" class="{{ Request::routeIs('unit.*') ? 'active' : '' }}">Data Unit</a>
                            </li>
                        @endcan
                        @can('TIRE_RUNNING')
                            <li><a href="/tirerunning" class="{{ Request::routeIs('tirerunning.*') ? 'active' : '' }}">Tire
                                    Movement</a>
                            </li>
                        @endcan
                        @can('TIRE_REPAIR')
                            <li><a href="/tirerepair" class="{{ Request::routeIs('tirerepair.*') ? 'active' : '' }}">Tire
                                    Repair Proccess</a></li>
                        @endcan
                        @can('DAILY_INSPECT')
                            <li><a href="/dailyinspect"
                                    class="{{ Request::routeIs('dailyinspect.*') ? 'active' : '' }}">Daily Monitoring</a>
                            </li>
                        @endcan
                        @can('DRIVER')
                            <li><a href="/driver" class="{{ Request::routeIs('driver.*') ? 'active' : '' }}">
                                    Driver</a></li>
                        @endcan
                        @can('JABATAN')
                            <li><a href="/jabatan" class="{{ Request::routeIs('jabatan.*') ? 'active' : '' }}">
                                    Jabatan</a></li>
                        @endcan
                        @can('DEPARTMENT')
                            <li><a href="/department" class="{{ Request::routeIs('department.*') ? 'active' : '' }}">
                                    Department</a></li>
                        @endcan
                        @can('TEKNISI')
                            <li><a href="/teknisi" class="{{ Request::routeIs('teknisi.*') ? 'active' : '' }}">
                                    Teknisi</a></li>
                        @endcan
                        @can('AKTIVITAS_PEKERJAAN')
                            <li><a href="/aktivitas-pekerjaan"
                                    class="{{ Request::routeIs('aktivitas-pekerjaan.*') ? 'active' : '' }}">
                                    Aktivitas Pekerjaan</a></li>
                        @endcan
                        @can('AREA_PEKERJAAN')
                            <li><a href="/area-pekerjaan"
                                    class="{{ Request::routeIs('area-pekerjaan.*') ? 'active' : '' }}">
                                    Area Pekerjaan</a></li>
                        @endcan
                        @can('FORECAST')
                            <li><a href="/forecast" class="{{ Request::routeIs('forecast.*') ? 'active' : '' }}">
                                    Forecast</a></li>
                        @endcan
                        @can('BREAKDOWNUNIT')
                            <li><a href="/breakdown-unit" class="{{ Request::routeIs('breakdown-unit.*') ? 'active' : '' }}">
                                    Breakdown Unit</a></li>
                        @endcan
                    </ul>
                </li>

                <li class="{{ Request::routeIs('daily-activity.*') ? 'active' : '' }}">
                    <a href="/daily-activity"><img src="{{ asset('assets/img/icons/dashboard.svg') }}"
                            alt="img"><span>
                            Daily Activity</span> </a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/purchase1.svg') }}"
                            alt="img"><span>
                            Data Report</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @can('REPORT')
                            <li><a href="/report-tire-status"
                                    class="{{ Request::routeIs('report.tirestatus') ? 'active' : '' }}">Report Status
                                    Tire</a></li>
                            <li><a href="/report-tire-running"
                                    class="{{ Request::routeIs('report.tirerunning') ? 'active' : '' }}">Report Tire
                                    Running</a></li>
                            <li><a href="/report-tire-activity"
                                    class="{{ Request::routeIs('report.activity') ? 'active' : '' }}">Report Tire
                                    Activity</a></li>
                            <li><a href="/report-tire-target-km"
                                    class="{{ Request::routeIs('report.tiretargetkm') ? 'active' : '' }}">Report Tire
                                    Target KM</a></li>

                            <li><a href="/report-tire-cost-brand"
                                    class="{{ Request::routeIs('report.tirecostbrand') ? 'active' : '' }}">Report Tire
                                    Cost By Brand</a>
                            </li>

                            <li><a href="/report-tire-cost-unit"
                                    class="{{ Request::routeIs('report.tirecostunit') ? 'active' : '' }}">Report Tire Cost
                                    By Unit</a>
                            </li>
                            <li><a href="/report-tire-cost-comparation"
                                    class="{{ Request::routeIs('report.tirecostcomparation') ? 'active' : '' }}">Report
                                    Tire Cost Comparation</a>
                            </li>

                            <li><a href="/report-time-daily-activity"
                                    class="{{ Request::routeIs('report.timedailyactivity') ? 'active' : '' }}">Report
                                    Time Daily Activity</a>
                            </li>
                        @endcan
                        @can('HISTORY_TIRE_MOVEMENT')
                            <li><a href="/historytire"
                                    class="{{ Request::routeIs('historytire.*') ? 'active' : '' }}">Report Daily
                                    Inspect</a></li>
                        @endcan
                        @can('HISTORY_TIRE')
                            <li><a href="/historytiremovement"
                                    class="{{ Request::routeIs('historytiremovement.*') ? 'active' : '' }}">Report Tire
                                    Movement</a></li>

                            <li><a href="/report-history-tire-scrap"
                                    class="{{ Request::routeIs('report.historytirescrap') ? 'active' : '' }}">Report
                                    History
                                    Tire Scrap</a></li>
                        @endcan
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/transfer1.svg') }}"
                            alt="img"><span>
                            Manajemen User</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if (Auth()->user()->id == 1)
                            @can('COMPANY')
                                <li><a href="/company" class="{{ Request::routeIs('company.*') ? 'active' : '' }}">Data
                                        Customer</a></li>
                            @endcan
                        @endif
                        @can('USER')
                            <li><a href="/user" class="{{ Request::routeIs('user.*') ? 'active' : '' }}">User</a></li>
                        @endcan
                        @can('PERMISSION')
                            <li><a href="/permission"
                                    class="{{ Request::routeIs('permission.*') ? 'active' : '' }}">Permission</a>
                            </li>
                        @endcan
                        @can('ROLE')
                            <li><a href="/role" class="{{ Request::routeIs('role.*') ? 'active' : '' }}">Role</a></li>
                        @endcan

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
