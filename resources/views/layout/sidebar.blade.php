<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row align-items-center" style="height: 64px;">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" style="margin-top: 0;" href="#">
                    <img src="{{ asset('app-assets/images/logo_mi_muhammadiyah_23_surabaya-removebg-preview.png') }}" width="35" alt="Logo">
                    <h1 class="brand-text">MIM 23</h1>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @if(Auth::guard('web')->user())
            @if(Auth::guard('web')->user()->role == 'admin')
            <li class="@yield('dashboard') nav-item">
                <a class="d-flex align-items-center" href="{{ route('dashboard-admin') }}">
                    <i class="fa-solid fa-desktop"></i><span class="menu-title text-truncate">Dashboard</span>
                </a>
            </li>
            <li class=" navigation-header">
                <span data-i18n="Apps &amp; Pages">Pages</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item has-sub @yield('master-user')">
                <a class="d-flex align-items-center" href="#">
                    <i class="fa-solid fa-users"></i><span class="menu-title text-truncate" data-i18n="Invoice">Master User</span>
                </a>
                <ul class="menu-content">
                    <li class="@yield('guru')">
                        <a class="d-flex align-items-center ml-1" href="{{ route('guru') }}">
                            <i class="fa-solid fa-chalkboard-user"></i><span class="menu-item text-truncate" data-i18n="List">Guru</span>
                        </a>
                    </li>
                    <li class="@yield('siswa')">
                        <a class="d-flex align-items-center ml-1" href="{{ route('siswa') }}">
                            <i class="fa-solid fa-graduation-cap"></i><span class="menu-item text-truncate" data-i18n="List">Siswa</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item @yield('sub-kelas')">
                <a class="d-flex align-items-center" href="{{ route('sub.kelas') }}">
                    <i class="fa-solid fa-house"></i><span class="menu-title text-truncate" data-i18n="Email">Master Kelas</span>
                </a>
            </li>
            <li class="nav-item @yield('mapel')">
                <a class="d-flex align-items-center" href="{{ route('mapel') }}">
                    <i class="fa-solid fa-book"></i><span class="menu-title text-truncate" data-i18n="Email">Master Mapel</span>
                </a>
            </li>
            <li class="nav-item @yield('tahun_ajaran')">
                <a class="d-flex align-items-center" href="{{ route('tahun.ajaran') }}">
                    <i class="fa-solid fa-calendar-week"></i><span class="menu-title text-truncate">Tahun Ajaran</span>
                </a>
            </li>
            <li class="nav-item @yield('jadwalBM')">
                <a class="d-flex align-items-center" href="{{ route('jadwalBM') }}">
                    <i class="fa-solid fa-clipboard-list"></i><span class="menu-title text-truncate">Master Jadwal BM</span>
                </a>
            </li>
            <li class="nav-item @yield('naik-kelas')">
                <a class="d-flex align-items-center" href="{{ route('naik.kelas') }}">
                    <i class="fa-solid fa-arrow-up-right-dots"></i><span class="menu-title text-truncate">Naik Kelas</span>
                </a>
            </li>
            <li class="nav-item @yield('alumni')">
                <a class="d-flex align-items-center" href="{{ route('alumni') }}">
                    <i class="fa-solid fa-user-graduate"></i><span class="menu-title text-truncate">Alumni</span>
                </a>
            </li>
            @endif
            @if(Auth::guard('web')->user()->role == 'guru')
            <li class="@yield('ujian') nav-item">
                <a class="d-flex align-items-center" href="{{ route('ujian') }}">
                    <i class="fa-solid fa-file-pen"></i><span class="menu-title text-truncate">Master Ujian</span>
                </a>
            </li>
            <li class="@yield('log') nav-item">
                <a class="d-flex align-items-center" href="{{ route('log.ujian') }}">
                    <i class="fa-solid fa-table-list"></i><span class="menu-title text-truncate">Log Ujian</span>
                </a>
            </li>
            @endif
            @endif
            @if(Auth::guard('siswa')->user())
            <li class="@yield('ujian') nav-item">
                <a class="d-flex align-items-center" href="{{ route('daftar.ujian.siswa') }}">
                    <i class="fa-solid fa-file-pen"></i><span class="menu-title text-truncate">Ujian</span>
                </a>
            </li>
            <li class="@yield('list-ujian-selesai') nav-item">
                <a class="d-flex align-items-center" href="{{ route('list.ujian.selesai') }}">
                    <i class="fa-solid fa-list-check"></i><span class="menu-title text-truncate">Ujian Selesai</span>
                </a>
            </li>
            @endif
            <li class=" navigation-header">
                <span data-i18n="Apps &amp; Pages">Lainnya</span><i data-feather="more-horizontal"></i>
            </li>
            @if(Auth::guard('siswa')->user())
            <li class="nav-item @yield('profile-siswa')">
                <a class="d-flex align-items-center" href="{{ route('profile.siswa') }}">
                    <i class="fa-regular fa-id-badge"></i><span class="menu-title text-truncate">Profile</span>
                </a>
            </li>
            @else
            <li class="nav-item @yield('profile')">
                <a class="d-flex align-items-center" href="{{ route('profile') }}">
                    <i class="fa-regular fa-id-badge"></i><span class="menu-title text-truncate">Profile</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a href="#">
                    <form class="d-flex align-items-center" action="/logout" method="post">
                        @csrf
                        <i class="fa-solid fa-right-from-bracket"></i><button type="submit" style="border: none; background-color: transparent; color:#625F6E; padding: 0;">Log Out</button>
                    </form>
                </a>
            </li>
        </ul>
    </div>
</div>