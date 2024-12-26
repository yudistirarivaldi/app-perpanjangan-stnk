<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
    </div>
    <div class="sidebar-brand-text mx-3"><img src="{{ asset('img/logo_bapenda.png') }}" alt="Logo Bapenda Banjarbaru" class="mb-2" width="220px"> <sup></sup></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" 
        data-target="#collapsePages"
        aria-expanded="{{ (Request::is('user') || Request::is('pelanggan') || Request::is('kategori') || Request::is('merk') || Request::is('time')) ? 'true' : 'false' }}"
        aria-controls="collapsePages">
        <i class="fas fa-database"></i>
        <span>Master Data</span>
    </a>
    <div id="collapsePages" class="collapse {{ (Request::is('user') || Request::is('pelanggan') || Request::is('kategori') || Request::is('merk') || Request::is('time')) ? 'show' : '' }}" 
         aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">

            @if (Auth::user()->role == "admin")
                <a class="collapse-item {{ Request::is('user') ? 'active' : '' }}" href="{{ route('user') }}">Pengguna</a>
            @endif
            <a class="collapse-item {{ Request::is('pelanggan') ? 'active' : '' }}" href="{{ route('pelanggan') }}">Pelanggan</a>
            <a class="collapse-item {{ Request::is('kategori') ? 'active' : '' }}" href="{{ route('kategori') }}">Kategori Kendaraan</a>
            <a class="collapse-item {{ Request::is('merk') ? 'active' : '' }}" href="{{ route('merk') }}">Merk Kendaraan</a>
            <a class="collapse-item {{ Request::is('time') ? 'active' : '' }}" href="{{ route('time') }}">Pengaturan Pengingat</a>
        </div>
    </div>
</li>

  <hr class="sidebar-divider">

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" 
        data-target="#collapseUtilities"
        aria-expanded="{{ (Request::is('vehicle') || Request::is('tax_payment')) ? 'true' : 'false' }}"
        aria-controls="collapseUtilities">
        <i class="fas fa-tools"></i>
        <span>Fitur Utama</span>
    </a>
    <div id="collapseUtilities" class="collapse {{ (Request::is('vehicle') || Request::is('tax_payment')) ? 'show' : '' }}" 
        aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ Request::is('vehicle') ? 'active' : '' }}" href="{{ route('vehicle') }}">Kendaraan</a>
            <a class="collapse-item {{ Request::is('tax_payment') ? 'active' : '' }}" href="{{ route('tax_payment') }}">Pembayaran Pajak</a>
        </div>
    </div>
  </li>

  <hr class="sidebar-divider">  

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" 
        data-target="#collapseTwo"
        aria-expanded="{{ Request::routeIs('reports.*') ? 'true' : 'false' }}"
        aria-controls="collapseTwo">
        <i class="fas fa-file-alt"></i>
        <span>Laporan</span>
    </a>
    <div id="collapseTwo" class="collapse {{ Request::routeIs('reports.*') ? 'show' : '' }}" 
        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ Request::routeIs('reports.payments') ? 'active' : '' }}" 
               href="{{ route('reports.payments') }}">Pembayaran Pajak</a>
            <a class="collapse-item {{ Request::routeIs('reports.vehicles') ? 'active' : '' }}" 
               href="{{ route('reports.vehicles') }}">Kendaraan</a>
            <a class="collapse-item {{ Request::routeIs('reports.notifications') ? 'active' : '' }}" 
               href="{{ route('reports.notifications') }}">Peringatan</a>
            <a class="collapse-item {{ Request::routeIs('reports.late-payments') ? 'active' : '' }}" 
               href="{{ route('reports.late-payments') }}">Telat Pembayaran</a>
            <a class="collapse-item {{ Request::routeIs('reports.revenue') ? 'active' : '' }}" 
               href="{{ route('reports.revenue') }}">Pendapatan Pajak</a>
        </div>
    </div>
  </li>


  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
