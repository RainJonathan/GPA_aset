<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add your sidebar menu items here -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link @if(request()->routeIs('dashboard')) active @endif">
              <i class="nav-icon fas fa-desktop"></i>
              <p>Dashboard</p>
            </a>
          </li>
        {{-- <li class="nav-item">
            <a href="{{ route('host.index') }}" class="nav-link @if(request()->routeIs('host.index')) active @endif">
                <i class="nav-icon fas fa-users"></i>
                <p>Tuan Rumah</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ route('asset.index') }}" class="nav-link @if(request()->routeIs('asset.index')) active @endif">
                <i class="nav-icon fas fa-box"></i>
                <p>Rekap Aset</p>
            </a>
        </li>
    </ul>
</nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>