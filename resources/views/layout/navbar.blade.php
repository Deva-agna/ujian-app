<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="fa-solid fa-bars"></i></a></li>
            </ul>
            <h3 style="margin-bottom: 0; font-size: 18px;">@yield('halaman')</h3>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <span>Hii, {{ Auth::guard('web')->user() ? Auth::guard('web')->user()->nama : Auth::guard('siswa')->user()->nama }}</span>
        </ul>
    </div>
</nav>