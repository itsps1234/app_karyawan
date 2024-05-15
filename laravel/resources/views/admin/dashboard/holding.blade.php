<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login Basic - Pages | Materio - Bootstrap Material Design Admin Template</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('admin/assets/img/favicon/favicon.ico')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/materialdesignicons.css')}}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/node-waves/node-waves.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/core.css')}}" class="template-customizer-core-css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/pages/page-auth.css')}}" />

    <!-- Helpers -->
    <script src="{{asset('admin/assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('admin/assets/js/config.js')}}"></script>
</head>

<body>
    <!-- Content -->

    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic">
            <div class="container-xxl flex-grow-1">
                <div class="row">
                    <h1 class="text-center">Welcome to <span>APP HRD</span></h1>
                    <!-- Congratulations card -->
                    <div class="col-md-4 col-lg-4">
                        <a href="{{ url('dashboard/holding/sp') }}">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-1">CV. SUMBER PANGAN</h4>
                                    <p class="pb-0">Best seller of the month</p>
                                    <h4 class="text-primary mb-1">$42.8k</h4>
                                    <p class="mb-2 pb-1">78% of target 🚀</p>
                                </div>
                                <img src="{{asset('admin/assets/img/icons/misc/triangle-light.png')}}" class="scaleX-n1-rtl position-absolute bottom-0 end-0" width="166" alt="triangle background" data-app-light-img="icons/misc/triangle-light.png" data-app-dark-img="icons/misc/triangle-dark.png" />
                                <img src="{{ url('public/holding/assets/img/logosp.png') }}" class="scaleX-n1-rtl position-absolute bottom-0 end-0 me-4 pb-2" width="150" alt="view sales" />
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <a href="{{ url('dashboard/holding/sps') }}">
                            <div class="card">
                                <div class="card-body">
                                    <figure class="mt-2">
                                        <blockquote class="blockquote">
                                            <h4 class="card-title mb-1">PT. SURYA PANGAN SEMESTA</h4>
                                        </blockquote>
                                        <figcaption class="blockquote-footer">
                                            Lokasi <cite title="Source Title">Pabrik</cite>
                                            <p><i class="mdi mdi-google-maps"></i>Kabupaten Kediri, Jawa Timur</p>
                                            <p><i class="mdi mdi-google-maps"></i>Kabupaten Ngawi, Jawa Timur</p>
                                            <p><i class="mdi mdi-google-maps"></i>Kabupaten Subang, Jawa Barat</p>
                                        </figcaption>
                                    </figure>
                                </div>
                                <img src="{{asset('admin/assets/img/icons/misc/triangle-light.png')}}" class="scaleX-n1-rtl position-absolute bottom-0 end-0" width="166" alt="triangle background" data-app-light-img="icons/misc/triangle-light.png" data-app-dark-img="icons/misc/triangle-dark.png" />
                                <img src="{{ url('public/holding/assets/img/logosps.png') }}" class="scaleX-n1-rtl position-absolute bottom-0 end-0 me-4 pb-2" width="150" alt="view sales" />
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <a href="{{ url('dashboard/holding/sip') }}">
                            <div class="card">
                                <div class="card-body">
                                    <figure class="mt-2">
                                        <blockquote class="blockquote">
                                            <h4 class="card-title mb-1">CV. SURYA INTI PANGAN</h4>
                                        </blockquote>
                                        <figcaption class="blockquote-footer">
                                            Lokasi <cite title="Source Title">Pabrik</cite>
                                            <p><i class="mdi mdi-google-maps"></i>Kabupaten Kediri, Jawa Timur</p>
                                        </figcaption>
                                    </figure>
                                </div>
                                <img src="{{asset('admin/assets/img/icons/misc/triangle-light.png')}}" class="scaleX-n1-rtl position-absolute bottom-0 end-0" width="166" alt="triangle background" data-app-light-img="icons/misc/triangle-light.png" data-app-dark-img="icons/misc/triangle-dark.png" />
                                <img src="{{ url('public/holding/assets/img/logosipbaru.png') }}" class="scaleX-n1-rtl position-absolute bottom-0 end-0 me-4 pb-2" width="200" alt="view sales" />
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <img src="{{asset('admin/assets/img/illustrations/tree-3.png')}}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block" />
            <img src="{{asset('admin/assets/img/illustrations/auth-basic-mask-light.png')}}" class="authentication-image d-none d-lg-block" alt="triangle-bg" data-app-light-img="illustrations/auth-basic-mask-light.png" data-app-dark-img="illustrations/auth-basic-mask-dark.png" />
            <img src="{{asset('admin/assets/img/illustrations/tree.png')}}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block" />
        </div>
    </div>

    <!-- / Content -->

    <div class="buy-now">
        <a href="https://themeselection.com/item/materio-bootstrap-html-admin-template/" target="_blank" class="btn btn-danger btn-buy-now">Upgrade to Pro</a>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('admin/assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/node-waves/node-waves.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('admin/assets/vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{asset('admin/assets/js/main.js')}}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>