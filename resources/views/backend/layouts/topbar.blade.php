<header id="page-topbar">
    <div class="navbar-header">
        <div class="container-fluid">

            <div class="float-end">

                <!-- Fullscreen Button -->
                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="mdi mdi-fullscreen"></i>
                    </button>
                </div>

                <!-- User Profile Dropdown -->
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user"
                            src="{{ URL::asset('build/images/users/avatar-2.png') }}" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1">
                            {{ auth()->user()->name }}
                        </span>
                        {{-- <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i> --}}
                    </button>
                    {{-- <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div> --}}
                </div>

            </div>

            <!-- Logo Text -->
            <div>
                <div class="navbar-brand-box">
                    <a href="{{ route('backend.index') }}" class="logo logo-dark d-flex align-items-center gap-2">
                        <i class="mdi mdi-city-variant font-size-24 text-white"></i>
                        <span class="font-size-18 text-white">DPMPTSP</span>
                    </a>
                </div>

                <!-- Tombol Toggle Sidebar (kalau butuh nanti, uncomment saja) -->
                {{--
                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                    id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                --}}
            </div>

        </div>
    </div>
</header>
