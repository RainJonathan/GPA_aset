<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add your sidebar menu items here -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link @if (request()->routeIs('dashboard')) active @endif">
                <i class="nav-icon fas fa-desktop"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item @if (request()->routeIs('host.*') || request()->routeIs('asset.*') || request()->routeIs('wilayah.*')) menu-open @endif">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-database"></i>
                <p>Master Data
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth()->user()->role == 1)
                    <li class="nav-item">
                        <a href="{{ route('wilayah.index') }}"
                            class="nav-link @if (request()->routeIs('wilayah.*')) active @endif">
                            <i class="nav-icon fas fa-map-marked-alt"></i>
                            <p>Wilayah</p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('asset.index') }}"
                        class="nav-link @if (request()->routeIs('asset.*')) active @endif">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Rekap Aset</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('host.index') }}"
                        class="nav-link @if (request()->routeIs('host.*')) active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Tuan Rumah</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item @if (request()->routeIs('tiket.*') || request()->routeIs('pengeluaran.*')) menu-open @endif">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-receipt"></i>
                <p>Transaksi
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('tiket.index') }}"
                        class="nav-link @if (request()->routeIs('tiket.*')) active @endif">
                        <i class="fas fa-tools nav-icon"></i>
                        <p>Pengajuan Perbaikan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengeluaran.index') }}"
                        class="nav-link @if (request()->routeIs('pengeluaran.*')) active @endif">
                        <i class="fas fa-money-bill-wave nav-icon"></i>
                        <p>Pengeluaran</p>
                    </a>
                </li>
                <!-- Add more submenu items as needed -->
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('notifikasi.index') }}" class="nav-link @if (request()->routeIs('notifikasi')) active @endif">
                <i class="nav-icon fas fa-bell"></i>
                <p>
                    Notifikasi
                    <span id="notification-count" class="badge badge-danger"></span>
                </p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchNotifikasi();
    });

    function fetchNotifikasi() {
        // Replace the URL with the actual endpoint to fetch history data
        var url = '{{ route('notifikasi.indexapi') }}';

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                // Call a function to update the notifications in your sidebar with the fetched data
                updateNotificationsCount(data);
            })
            .catch(error => {
                console.error('Error fetching notification data:', error);
                // Optionally, log or display the error message
            });
    }

    function updateNotificationsCount(count) {
        var badgeElement = document.getElementById('notification-count');
        if (badgeElement) {
            badgeElement.textContent = count['notifcount'];
        }
    }
</script>
