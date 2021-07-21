    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <div class="navbar-brand-box">
                    <a href="{{ url('/index') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
                        </span>
                    </a>

                    <a href="{{ url('/index') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-light.svg') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="19">
                        </span>
                    </a>
                </div>
                <button type="button"
                    class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                    data-toggle="collapse" data-target="#topnav-menu-content">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </div>
            <div class="d-flex">

                <div class="dropdown d-inline-block d-lg-none ml-2">
                    <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                        aria-labelledby="page-header-search-dropdown">

                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..."
                                        aria-label="Recipient's username">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown d-none d-lg-inline-block ml-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="bx bx-fullscreen"></i>
                    </button>
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user"
                            src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ml-1">{{  Auth::user()->name  }}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle mr-1"></i>
                            Profile</a>
                        <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle mr-1"></i> My
                            Wallet</a>
                        <a class="dropdown-item d-block" href="#"><span
                                class="badge badge-success float-right">11</span><i
                                class="bx bx-wrench font-size-16 align-middle mr-1"></i> Settings</a>
                        <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                        <?php
                        // if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                        // $loggedin = true;
                        // }else{
                        // $loggedin = false;
                        // }
                        // if(!$loggedin){
                        // echo '<a class="dropdown-item text-danger" href="login.php"><i
                            //     class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Login</a><a
                            // class="dropdown-item" href="singup.php"><i
                            //     class="bx bx-wallet font-size-16 align-middle mr-1"></i> singup</a>';
                        // }
                        // if($loggedin){
                        // echo '<div class="dropdown-divider"></div><a class="dropdown-item text-danger"
                            // href="logout.php"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i>
                            // Logout</a>';
                        // }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </header>
