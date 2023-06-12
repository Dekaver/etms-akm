<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
                    <a href="/dashboard"><img src="{{ asset('assets/img/icons/dashboard.svg') }}" alt="img"><span>
                            Dashboard</span> </a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/purchase1.svg') }}"
                            alt="img"><span>
                            Grafik</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="/tire-performance"
                                class="{{ Request::routeIs('tire-performance') ? 'active' : '' }}">Tire Performance</a>
                        </li>
                        <li><a href="/tire-scrap" class="{{ Request::routeIs('tire-scrap') ? 'active' : '' }}">Tire
                                Scrap</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/expense1.svg') }}"
                            alt="img"><span>
                            Data Tire</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @can('TIRE_MANUFACTURE')
                            <li>
                                <a href="/tiremanufacture"
                                    class="{{ Request::routeIs('tiremanufacture.*') ? 'active' : '' }}">
                                    Tire Manufacture
                                </a>
                            </li>
                        @endcan
                        <li><a href="/tirepattern" class="{{ Request::routeIs('tirepattern.*') ? 'active' : '' }}">Tire
                                Pattern</a></li>
                        <li><a href="/tiresize" class="{{ Request::routeIs('tiresize.*') ? 'active' : '' }}">Tire
                                Size</a></li>
                        <li><a href="/tirecompound"
                                class="{{ Request::routeIs('tirecompound.*') ? 'active' : '' }}">Tire Compound</a></li>
                        <li><a href="/tirestatus" class="{{ Request::routeIs('tirestatus.*') ? 'active' : '' }}">Tire
                                Status</a></li>
                        <li><a href="/tiredamage" class="{{ Request::routeIs('tiredamage.*') ? 'active' : '' }}">Tire
                                Damage</a></li>
                        <li><a href="/tiremaster" class="{{ Request::routeIs('tiremaster.*') ? 'active' : '' }}">Tire
                                Data Master</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/quotation1.svg') }}"
                            alt="img"><span>
                            Data</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="/site" class="{{ Request::routeIs('site.*') ? 'active' : '' }}">Site</a></li>
                        <li><a href="/unitstatus" class="{{ Request::routeIs('unitstatus.*') ? 'active' : '' }}">Unit
                                Status</a></li>
                        <li><a href="/unitmodel" class="{{ Request::routeIs('unitmodel.*') ? 'active' : '' }}">Unit
                                Model</a></li>
                        <li><a href="/unit" class="{{ Request::routeIs('unit.*') ? 'active' : '' }}">Data Unit</a>
                        </li>
                        <li><a href="/tiremovement"
                                class="{{ Request::routeIs('tiremovement.*') ? 'active' : '' }}">Tire Movement</a></li>
                        <li><a href="/tiredisposisi"
                                class="{{ Request::routeIs('tiredisposisi.*') ? 'active' : '' }}">Tire Disposisi</a>
                        </li>
                        <li><a href="/tirerepair" class="{{ Request::routeIs('tirerepair.*') ? 'active' : '' }}">Tire
                                Repair</a></li>
                        <li><a href="/tirerunning" class="{{ Request::routeIs('tirerunning.*') ? 'active' : '' }}">Tire
                                Running Unit</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/transfer1.svg') }}"
                            alt="img"><span>
                            Manajemen User</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="">Data Customer</a></li>
                        <li><a href="">Profil</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/return1.svg') }}"
                            alt="img"><span>
                            Data History</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="/historytire">Tire Movement</a></li>
                        <li><a href="/dailyinspect">Daily Inspect Report</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
