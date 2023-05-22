<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
        <img src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold">Kios Sahabat Tani</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{--            <div class="image">--}}
            {{--                <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" width="160" class="img-circle elevation-2"--}}
            {{--                     alt="User Image">--}}
            {{--            </div>--}}
            <div class="info">
                {{--          <a href="#" class="d-block">{{Auth::user()->username}}</a>--}}
                <a href="#" class="d-block">
                    <i class="fas fa-user mx-1"></i>
                    {{Auth::user()->username}} <span style="font-weight: bold"> [
                    @if(Auth::user()->role == 0)
                            Owner
                        @elseif(Auth::user()->role == 1)
                            Admin
                        @elseif(Auth::user()->role == 2)
                            Kasir
                        @endif
                    ]
                    </span>
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if(Auth::user()->role == 0)
                    <li class="nav-item">
                        <a href="{{ url('/user') }}" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-users"></i>
                            <p>
                                Pengguna
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ url('/pemasok') }}" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-users"></i>
                        <p>
                            Pemasok
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/kategori') }}" class="nav-link">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            Kategori Barang
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/barang') }}" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Data Barang
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>
                            Transaksi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/kasir') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Transaksi Keluar
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/transaksimasuk') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Transaksi Masuk
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Laporan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/laporankeluar') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Laporan Transaksi Keluar
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/laporanmasuk') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Laporan Transaksi Masuk
                                </p>
                            </a>
                        </li>
                        @if(Auth::user()->role != 2)
                            <li class="nav-item">
                                <a href="{{ url('/riwayat') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Riwayat
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
