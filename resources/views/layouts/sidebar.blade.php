{{-- SIDEBAR --}}
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    @if (Auth::user()->role->name == 'admin')
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
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
                        <li class="nav-item"> <a class="nav-link"
                                href="{{ route('admin.operator.index') }}">Operator</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('admin.driver.index') }}">Driver</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    @elseif (Auth::user()->role->name == 'driver')
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
        </ul>
    @elseif (Auth::user()->role->name == 'operator')
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
        </ul>
    @endif
</nav>
