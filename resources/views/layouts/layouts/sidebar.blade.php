<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title ps-4" id="offcanvasExampleLabel">Aplikasi Inventori</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="sidebar mb-4">
            <ul class="nav flex-column" id="nav_accordion">
                <li class="nav-item">
                    <a class="nav-link fs-5 ps-4" href="{{route('home')}}"> Dashboard </a>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link fs-5 ps-4" href="#" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Master Data <i style="float: right" class="bi small bi-caret-down-fill"></i> </a>
                    <ul class="submenu collapse" id="collapseExample" style="">
                        <li><a class="nav-link fs-5 ps-4" href="{{ route('barang') }}">Data Barang </a></li>
                        <li><a class="nav-link fs-5 ps-4" href="{{ route('kategori') }}">Data Kategori </a></li>
                        <li><a class="nav-link fs-5 ps-4" href="{{ route('puskesmas') }}">Data Puskesmas </a>
                        </li>
                    </ul>
                </li>

                @if (Auth::user()->level == 'admin')
                <li class="nav-item">
                    <a class="nav-link fs-5 ps-4" href="{{ route('masuk') }}"> Barang Masuk </a>
                </li>
                @endif

                @livewire('notif-permintaan-component')
                @if (Auth::user()->level != 'user')
                <li class="nav-item has-submenu">
                    <a class="nav-link fs-5 ps-4" href="#" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapseExample">
                        Laporan <i style="float: right" class="bi small bi-caret-down-fill"></i> </a>
                    <ul class="submenu collapse" id="collapse2" style="">
                        <li><a class="nav-link fs-5 ps-4" href="{{ route('laporan-barang') }}">Data Barang </a>
                        </li>
                        <li><a class="nav-link fs-5 ps-4" href="{{ route('laporan-permintaan') }}">Permintaan </a> </li>
                    </ul>
                </li>
                @endif

                @if (Auth::user()->level == 'admin')
                <li class="nav-item">
                    <a class="nav-link fs-5 ps-4" href="{{ route('pengguna') }}"> Pengguna </a>
                </li>
                @endif

            </ul>
        </nav>
    </div>
</div>