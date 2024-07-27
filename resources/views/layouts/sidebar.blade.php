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
    @elseif (Auth::user()->role->name == 'manager_operasional')
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('manager-operasional.dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
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
                        <li class="nav-item"> <a class="nav-link"
                                href="{{ route('operator.checkpoint.index') }}">Checkpoint</a>
                        </li>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('operator.maptracking.index') }}">
                    <i class="feather icon-map menu-icon"></i>
                    <span class="menu-title">Map Tracking</span>
                </a>
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
                @php
                    $driver = auth()->user()->driver;
                    $suratJalan = \App\Models\SuratJalan::where('status', 'dikirim')
                        ->where('driver_id', $driver->id)
                        ->latest()
                        ->first();
                @endphp

                @if ($suratJalan)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('driver.maptracking.show', ['id' => $suratJalan->id]) }}">
                            <i class="feather icon-map menu-icon"></i>
                            <span class="menu-title">Map Tracking</span>
                        </a>
                    </li>
                @endif
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
            @endif

            <li class="nav-item">
                <a class="nav-link" href="{{ route('driver.riwayat.index') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">History</span>
                </a>
            </li>
        </ul>
    @endif
</nav>
