    {{-- <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
        <div class="container">
            <div class="card login-card">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <img src="{{asset('assets/page_login/login.jpg')}}" alt="login" class="login-card-img">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <div class="brand-wrapper">
                                <img src="{{asset('assets/page_login/logo.svg')}}" alt="logo" class="logo">
                            </div>
                            <p class="login-card-description">Sign into your account</p>
                            <form method="POST" id="myForm" action="{{ url('/login-proses') }}">
                                 @csrf
                                <div class="form-group">
                                    <label for="username" class="sr-only">Email</label>
                                    <input type="text" id="username" class="form-control" @error('username') is-invalid @enderror name="username" value="{{ old('username') }}" autocomplete="username" autofocus placeholder="Username">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                                </div>

                                <button class="btn btn-block login-btn mb-4" type="submit">Login</button>
                            </form>
                            <a href="#!" class="forgot-password-link">Forgot password?</a>
                            <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
                            <nav class="login-card-footer-nav">
                                <a href="#!">Terms of use.</a>
                                <a href="#!">Privacy policy</a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main> --}}
    <!DOCTYPE html>
    <html lang="en">
    <head>
        
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, minimal-ui, viewport-fit=cover">
        <meta name="theme-color" content="#2196f3">
        <meta name="author" content="DexignZone" /> 
        <meta name="keywords" content="" /> 
        <meta name="robots" content="" /> 
        <meta name="description" content="Jobie - Job Portal Mobile App Template ( Bootstrap 5 + PWA )"/>
        <meta property="og:title" content="Jobie - Job Portal Mobile App Template ( Bootstrap 5 + PWA )" />
        <meta property="og:description" content="Jobie - Job Portal Mobile App Template ( Bootstrap 5 + PWA )" />
        <meta property="og:image" content="https://jobie.dexignzone.com/mobile-app/xhtml/social-image.png"/>
        <meta name="format-detection" content="telephone=no">
        
        <!-- Favicons Icon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
        
        <!-- Title -->
        <title>APPS KARYAWAN</title>
        
        <!-- Stylesheets -->
        <link rel="stylesheet" href="{{ asset('assets/assets_users/vendor/swiper/swiper-bundle.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets_users/css/style.css') }}">
        
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Racing+Sans+One&display=swap" rel="stylesheet">
    
    </head>   
    <body>
    <div class="page-wraper">
    
        <!-- Preloader -->
        <div id="preloader">
            <div class="spinner"></div>
        </div>
        <!-- Preloader end-->
    
        <!-- Page Content -->
        <div class="page-content">
            
            <!-- Banner -->
            <div class="banner-wrapper shape-1">
                <div class="container inner-wrapper">
                    <h2 class="dz-title">Sign In</h2>
                    <p class="mb-0">Please sign in to My SP</p>
                </div>
            </div>
            <!-- Banner End -->
            
            <div class="container">
                <div class="account-area">
                    <form method="POST" action="{{ url('/login-proses') }}">
                        @csrf
                        <div class="input-group">
                            <input type="text" id="username" class="form-control" @error('username') is-invalid @enderror name="username" value="{{ old('username') }}" autocomplete="username" autofocus placeholder="Username">
                        </div>
                        <div class="input-group">
                            {{-- <input type="password" placeholder="Password" id="dz-password" class="form-control be-0"> --}}
                            <input type="password" name="password" id="dz-password" id="password" class="form-control be-0" placeholder="***********">
                            <span class="input-group-text show-pass"> 
                                <i class="fa fa-eye-slash"></i>
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <a href="forgot-password.html" class="btn-link d-block text-center">Forgot your password?</a>
                        <div class="input-group">
                            <button class="btn mt-2 btn-primary w-100 btn-rounded" type="submit">Login</button>
                        </div>
                    </form>
                    <div class="text-center p-tb20">
                        <span class="saprate">Or sign in with</span>
                    </div>
                    <div class="social-btn-group text-center">
                        <a href="https://www.google.com/" target="_blank" class="social-btn"><img src="{{ asset('assets/assets_users/images/social/google.png') }}" alt="socila-image"></a>
                        <a href="https://www.facebook.com/" target="_blank" class="social-btn ms-3"><img src="{{ asset('assets/assets_users/images/social/facebook.png') }}" alt="social-image"></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Content End -->
        
        <!-- Footer -->
        <footer class="footer fixed">
            <div class="container">
                <a href="register.html" class="btn btn-primary light btn-rounded text-primary d-block">Create account</a>
            </div>
        </footer>
        <!-- Footer End -->
        
        <!-- Theme Color Settings -->
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom">
            <div class="offcanvas-body small">
                <ul class="theme-color-settings">
                    <li>
                        <input class="filled-in" id="primary_color_8" name="theme_color" type="radio" value="color-primary" />
                        <label for="primary_color_8"></label>
                        <span>Default</span>
                    </li>
                    <li>
                        <input class="filled-in" id="primary_color_2" name="theme_color" type="radio" value="color-green" />
                        <label for="primary_color_2"></label>
                        <span>Green</span>
                    </li>
                    <li>
                        <input class="filled-in" id="primary_color_3" name="theme_color" type="radio" value="color-blue" />
                        <label for="primary_color_3"></label>
                        <span>Blue</span>
                    </li>
                    <li>
                        <input class="filled-in" id="primary_color_4" name="theme_color" type="radio" value="color-pink" />
                        <label for="primary_color_4"></label>
                        <span>Pink</span>
                    </li>
                    <li>
                        <input class="filled-in" id="primary_color_5" name="theme_color" type="radio" value="color-yellow" />
                        <label for="primary_color_5"></label>
                        <span>Yellow</span>
                    </li>
                    <li>
                        <input class="filled-in" id="primary_color_6" name="theme_color" type="radio" value="color-orange" />
                        <label for="primary_color_6"></label>
                        <span>Orange</span>
                    </li>
                    <li>
                        <input class="filled-in" id="primary_color_7" name="theme_color" type="radio" value="color-purple" />
                        <label for="primary_color_7"></label>
                        <span>Purple</span>
                    </li>
                    <li>
                        <input class="filled-in" id="primary_color_1" name="theme_color" type="radio" value="color-red" />
                        <label for="primary_color_1"></label>
                        <span>Red</span>
                    </li>
                    <li>
                        <input class="filled-in" id="primary_color_9" name="theme_color" type="radio" value="color-lightblue" />
                        <label for="primary_color_9"></label>
                        <span>Lightblue</span>
                    </li>
                    <li>
                        <input class="filled-in" id="primary_color_10" name="theme_color" type="radio" value="color-teal" />
                        <label for="primary_color_10"></label>
                        <span>Teal</span>
                    </li>
                    <li>
                        <input class="filled-in" id="primary_color_11" name="theme_color" type="radio" value="color-lime" />
                        <label for="primary_color_11"></label>
                        <span>Lime</span>
                    </li>
                    <li>
                        <input class="filled-in" id="primary_color_12" name="theme_color" type="radio" value="color-deeporange" />
                        <label for="primary_color_12"></label>
                        <span>Deeporange</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Theme Color Settings End -->
    </div>
    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('assets/assets_users/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/assets_users/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/assets_users/js/settings.js') }}"></script>
    <script src="{{ asset('assets/assets_users/js/custom.js') }}"></script>
    </body>
    </html>