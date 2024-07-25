<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="mdi mdi-menu mdi-24px"></i>
        </a>
    </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
                <button type="button" class="btn btn-outline-primary waves-effect">
                    <span class="tf-icons mdi mdi-calendar-clock-outline me-1"></span>
                    <span class="text-center" style="font-size: 13pt; text-align: center;">{{\Carbon\Carbon::now()->isoFormat('DD MMMM YYYY');}}&nbsp;&nbsp;</span><br>
                    <span class="text-center" style="font-size: 13pt; text-align: center;" id="jam_sekarang"></span>
                </button>
            </div>
            <div class="col-lg-4">
                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Search -->
                    <script>
                        setInterval(customClock, 500);

                        function customClock() {
                            var time = new Date();
                            var hrs = (time.getHours() < 10 ? '0' : '') + time.getHours();
                            var min = (time.getMinutes() < 10 ? '0' : '') + time.getMinutes();
                            var sec = (time.getSeconds() < 10 ? '0' : '') + time.getSeconds();
                            document.getElementById('jam_sekarang').innerHTML = hrs + ":" + min + ":" + sec;
                        }
                    </script>
                    <!-- /Search -->

                    <ul class="navbar-nav flex-row align-items-center ms-auto">

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown" style="right: 1%;">
                            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="{{asset('admin/assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                                <li>
                                    <a class="dropdown-item pb-2 mb-1" href="#">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2 pe-1">
                                                <div class="avatar avatar-online">
                                                    <img src="{{asset('admin/assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0">ADMIN</h6>
                                                <small class="text-muted">Admin</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider my-1"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="mdi mdi-account-outline me-1 mdi-20px"></i>
                                        <span class="align-middle">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider my-1"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{url('/logout')}}">
                                        <i class="mdi mdi-power me-1 mdi-20px"></i>
                                        <span class="align-middle">Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

</nav>