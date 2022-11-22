<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="fa-solid fa-bars"></i></a></li>
            </ul>
            <h3 style="margin-bottom: 0; font-size: 18px;">@yield('halaman')</h3>
        </div>
        <ul class="nav navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">{{ auth()->user()->nama }}</span>
                        <span class="user-status text-uppercase">{{ auth()->user()->role }}</span>
                    </div>
                    <span class="avatar">
                        @if(auth()->user()->img)
                        <img class="round" src="{{ asset('foto/' . auth()->user()->img) }}" alt="avatar" height="40" width="40" style="object-fit: cover;">
                        @else
                        <img class="round" src="{{ asset('app-assets/images/profile/user-uploads/user-boy.png') }}" alt="avatar" height="40" width="40" style="object-fit: cover;">
                        @endif
                        <span class="avatar-status-online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    @if(Auth::guard('siswa')->user())
                    <a class="dropdown-item" href="{{ route('profile.siswa') }}"><i class="fa-regular fa-user"></i> Profile</a>
                    @else
                    <a class="dropdown-item" href="{{ route('profile') }}"><i class="fa-regular fa-user"></i> Profile</a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        @method('put')
                        <button class="dropdown-item w-100" href="page-auth-login-v2.html"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </form>
                </div>
            </li>
            <!-- <span>Hii, {{ Auth::guard('web')->user() ? Auth::guard('web')->user()->nama : Auth::guard('siswa')->user()->nama }}</span> -->
        </ul>
    </div>
</nav>