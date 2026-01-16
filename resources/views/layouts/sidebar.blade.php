<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/samaji.png') }}" style="max-width:50px;">
        </div>
        <div class="sidebar-brand-text mx-3">SAMAJI FINANCE</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->is('aset*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('aset.index') }}">
            <i class="fas fa-fw fa-boxes"></i>
            <span>ASET</span></a>
    </li>

    <li class="nav-item {{ request()->is('saham*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('saham.index') }}">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>SAHAM & REKSADANA</span></a>
    </li>

    <li class="nav-item {{ request()->is('income*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('income.index') }}">
            <i class="fas fa-fw fa-hand-holding-usd"></i>
            <span>INCOME</span></a>
    </li>

    <li class="nav-item {{ request()->is('maintenance*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('maintenance.index') }}">
            <i class="fas fa-fw fa-tools"></i>
            <span>MAINTENANCE</span></a>
    </li>

    <li class="nav-item {{ request()->is('saving*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('saving.index') }}">
            <i class="fas fa-fw fa-piggy-bank"></i>
            <span>SAVING</span></a>
    </li>
    
    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>