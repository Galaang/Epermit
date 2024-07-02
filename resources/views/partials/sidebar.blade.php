<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <div class="container">
                <a href="{{route('dashboard')}}" class="navbar-brand  mb-3 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('img/logo.png') }}" style="width: 48px" class="" alt="">
                    <h4 class="text-primary mt-3"></i>E-Permit PNC</h3>
                </a>
        </div>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="ms-3">
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                <span>{{ Auth::user()->jabatan->name }}</span>
            </div>
        </div>

        <div class="navbar-nav w-100">
            <a href="{{ route('dashboard') }}" {{ \Route::is('dashboard') ? 'active' : '' }}
                class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            @if (auth()->check() && auth()->user()->role_id == '1')
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                            class="bi bi-clipboard2-fill me-2"></i>Permohonan Izin</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="{{ route('form_izin') }}" class="dropdown-item">Permohonan</a>
                        <a href="{{ route('riwayat_permohonan') }}" class="dropdown-item">Riwayat Permohonan</a>
                        <a href="element.html" class="dropdown-item">Other Elements</a>
                    </div>
                </div>
            @endif

            @if (auth()->check() && auth()->user()->role_id == 2)
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                            class="bi bi-clipboard2-fill me-2"></i>Permohonan Izin</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="{{ route('form_izin') }}" class="dropdown-item">Permohonan</a>
                        <a href="{{ route('riwayat_permohonan') }}" class="dropdown-item">Riwayat Permohonan</a>
                        @if (auth()->check() && auth()->user()->jabatan_id == 2)
                        <a href="{{ route('data_permohonan') }}" class="dropdown-item">Data Permohonan Izin</a>
                        @elseif (auth()->check() && auth()->user()->jabatan_id == 3)
                        <a href="{{ route('data_permohonan_kajur') }}" class="dropdown-item">Data Permohonan Izin</a>
                        @endif
                        <a href="element.html" class="dropdown-item">Other Elements</a>
                    </div>
                </div>
            @endif
            @if (auth()->check() && auth()->user()->role_id == 3)
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                            class="bi bi-clipboard2-fill me-2"></i>Permohonan Izin</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="{{ route('form_izin') }}" class="dropdown-item">Permohonan</a>
                        <a href="{{ route('riwayat_permohonan') }}" class="dropdown-item">Riwayat Permohonan</a>
                        <a href="{{ route('data_permohonan_wadir') }}" class="dropdown-item">Data Permohonan Izin</a>
                        <a href="element.html" class="dropdown-item">Other Elements</a>
                    </div>
                </div>
            @endif

            @if (auth()->check() && auth()->user()->role_id == '4')
                <a href="{{ route('riwayatpermohonanBaup') }}" class="nav-item nav-link"><i
                        class="bi bi-clipboard2-fill me-2"></i></i>Riwayat Permohonan</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                            class="bi bi-person-fill me-2"></i>Pegawai</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="{{ route('pegawai') }}" class="dropdown-item">Pegawai</a>
                        <a href="{{ route('unit-kerja') }}" class="dropdown-item">Unit Kerja</a>
                        <a href="{{ route('pangkat-jabatan') }}" class="dropdown-item">Pangkat Jabatan</a>
                        <a href="{{ route('jabatan') }}" class="dropdown-item">Jabatan</a>
                    </div>
                </div>
            @endif
        </div>
    </nav>
</div>
