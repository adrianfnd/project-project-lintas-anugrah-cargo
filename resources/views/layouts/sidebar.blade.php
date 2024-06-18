{{-- SIDEBAR --}}
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    @if (Auth::user()->role->name == 'admin')
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">List Data</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link"
                                href="{{ route('admin.operator.index') }}">Operator</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.driver.index') }}">Driver</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    @elseif (Auth::user()->role->name == 'operator')
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('operator.dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                    aria-controls="ui-basic">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">List Data</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('operator.paket.index') }}">Paket</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('operator.driver.index') }}">Driver</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('operator.suratjalan.index') }}">Surat
                                Jalan</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('operator.riwayat.index') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">History</span>
                </a>
            </li>
        </ul>
    @elseif (Auth::user()->role->name == 'driver')
        <ul class="nav">
            @if (auth()->user()->driver->status == 'dalam perjalanan')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('driver.maptracking.show') }}">
                        <i class="feather icon-map menu-icon"></i>
                        <span class="menu-title">Map Tracking</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->driver->status == 'menunggu')
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                        aria-controls="ui-basic">
                        <i class="icon-layout menu-icon"></i>
                        <span class="menu-title">List Data</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link"
                                    href="{{ route('driver.suratjalan.index') }}">Surat
                                    Jalan</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('driver.riwayat.index') }}">
                        <i class="icon-grid menu-icon"></i>
                        <span class="menu-title">History</span>
                    </a>
                </li>
            @endif
        </ul>
    @endif
</nav>
