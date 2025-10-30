<!DOCTYPE html>
<html lang="en">


<!-- molla/index-1.html  22 Nov 2019 09:55:06 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>International Relations - Department of Telecommunications</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Layerloop - 3d pronted Store">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


<!-- Bootstrap CSS (if not included) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS (if not included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('front/assets/images/icons/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('front/assets/images/icons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('front/assets/images/icons/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('front/assets/images/icons/favicon-32x32.png')}}">
    <link rel="mask-icon" href="{{asset('front/assets/images/icons/favicon-32x32.png')}}" color="#666666">
    <link rel="shortcut icon" href="{{asset('front/assets/images/icons/favicon-32x32.png')}}">
    <meta name="apple-mobile-web-app-title" content="Layerloop">
    <meta name="application-name" content="Layerloop">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="{{asset('front/assets/images/icons/favicon-32x32.png')}}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{asset('front/assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css')}}">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{asset('front/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/plugins/owl-carousel/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/plugins/magnific-popup/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/plugins/jquery.countdown.css')}}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{asset('front/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/skins/skin-demo-2.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/demos/demo-2.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Government Theme CSS -->
    <link rel="stylesheet" href="{{asset('css/government-theme.css')}}">
    <!-- Google tag (gtag.js) -->
<style>
    .minister-photo{
        margin: 0px auto 6px !important;
            width: 90px !important;
    height: 90px !important;
}

.minister-name{
    line-height: 1.3;
}


.minister-card{
    border-left: 6px solid #4a90e2 !important;
}

.updates-scroll-container {
    min-height: 461px;
    height: auto !important;
}


#scroll-top{
        width: 4rem !important;
    height: 4rem !important;
    border-radius: 50% !important;
    background-color:#FF9933 !important;
    color: #fff !important;
}


#scroll-top:hover, #scroll-top:focus{
    background-color: #4a90e2 !important;
}
</style>

<!-- Vite Assets -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
<style>
.product-image-manual {
    width: 100%;
    height: 250px; /* Adjust this value for your desired square size */
    object-fit: cover;
    object-position: center;
    border-radius: 6px; /* optional for soft corners */
    background-color: #f8f8f8; /* fallback background */
}
.product-manual{
    border: 1px solid #ddd !important;
    border-radius: 10px !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
}
    /* Footer Bar */
    .mobile-footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(10px);
      display: flex;
      justify-content: space-around;
      align-items: center;
      padding-bottom: 10px;
      border-top: 1px solid #ddd;
      box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
      z-index: 999;
    }
    .btn-cart{
        border-radius: 7px;
    }

    .mobile-footer a {
      flex: 1;
      text-align: center;
      font-size: 14px;
      text-decoration: none;
      color: #333;
    }

    .mobile-footer a i {
      display: block;
      font-size: 3rem;
      
    }

    /* Show only on mobile */
    @media(min-width: 768px) {
      .mobile-footer {
        display: none;
      }
    }.btn-wishlist.active {
    color: #fff !important;
    background-color: #e63946 !important; /* red heart */
    border-radius: 50%;
    border-color: #e63946 !important;
}
</style>

    <div class="page-wrapper">
        @include('frontend.partials.header')


            @yield('content')
        
        @include('frontend.partials.footer')
        <div class="mobile-footer">
           <a href="{{url('/')}}" title="My account">
                        <div class="icon">
                            <i class="icon-user" style="    margin-bottom: -15px;"></i>
                            Home
                        </div>
                    </a>
            <a href="{{ url('wishlist') }}" title="Wishlist">
        <div class="icon position-relative">
            <i class="icon-heart-o" style="margin-bottom: -15px;"></i>
            Wishlist
            <span class="badge bg-danger position-absolute" style="top: 0; right: 0; font-size: 10px;">
               
            </span>
        </div>
    </a>
            <a href="{{url('cart')}}" title="My account">
                        <div class="icon">
                            <i class="icon-shopping-cart" style="    margin-bottom: -15px;"></i>
                            Cart
                        </div>
                    </a>
            <a href="{{url('account')}}" title="My account">
                        <div class="icon">
                            <i class="icon-user" style="    margin-bottom: -15px;"></i>
                            Account
                        </div>
                    </a>
        </div>
        <!-- End .footer -->
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

        @include('frontend.partials.mobile-header')
    <!-- Mobile Menu -->

    <!-- Sign in / Register Modal -->
    <!-- Sign In / Register Modal -->
<div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-content-5">

                            {{-- Sign In Form --}}
                            <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password *</label>
                                        <input type="password" class="form-control" name="password" required>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>LOG IN</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="signin-remember">
                                            <label class="custom-control-label" for="signin-remember">Remember Me</label>
                                        </div>

                                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot Your Password?</a>
                                    </div>
                                </form>
                            </div>

                            {{-- Register Form --}}
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <form action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email *</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password *</label>
                                        <input type="password" class="form-control" name="password" required>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password *</label>
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>SIGN UP</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="register-policy" required>
                                            <label class="custom-control-label" for="register-policy">I agree to the <a href="#">privacy policy</a> *</label>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div><!-- End .tab-content -->

                        <div class="form-choice">
                            <p class="text-center">or sign in with</p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="" class="btn btn-login btn-g">
                                        <i class="icon-google"></i> Login With Google
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="" class="btn btn-login btn-f">
                                        <i class="icon-facebook-f"></i> Login With Facebook
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div><!-- End .form-tab -->
                </div><!-- End .form-box -->
            </div><!-- End .modal-body -->
        </div><!-- End .modal-content -->
    </div><!-- End .modal-dialog -->
</div>
<!-- End .modal -->
    
    @include('frontend.partials.newsletter')


</body>

    <!-- @if(session('success'))
    <script>
        Swal.fire({
            title: '🎉 Product Added!',
            text: "{{ session('success') }}",
            icon: 'success',
            showConfirmButton: true,
            confirmButtonText: 'Continue Shopping 🛍️',
            confirmButtonColor: '#00b894',
            background: '#f9f9f9',
            customClass: {
                popup: 'animated fadeInDown faster'
            },
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif -->
    <!-- Plugins JS File -->
    <script src="{{asset('front/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('front/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('front/assets/js/jquery.hoverIntent.min.js')}}"></script>
    <script src="{{asset('front/assets/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('front/assets/js/superfish.min.js')}}"></script>
    <script src="{{asset('front/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('front/assets/js/jquery.plugin.min.js')}}"></script>
    <script src="{{asset('front/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('front/assets/js/jquery.countdown.min.js')}}"></script>
    <!-- Main JS File -->
    <script src="{{asset('front/assets/js/main.js')}}"></script>
    <script src="{{asset('front/assets/js/demos/demo-2.js')}}"></script>


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



<script>

</script>

<script>




   <script>
    function showToastr(type, message) {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        };

        if (type === 'success') {
            toastr.success(message, 'Success');
        } else {
            toastr.error(message, 'Error');
        }
    }

    @if(session('success'))
        showToastr('success', @json(session('success')));
    @endif

    @if(session('error'))
        showToastr('error', @json(session('error')));
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            showToastr('error', @json($error));
        @endforeach
    @endif
</script>
</body>



<!-- molla/index-1.html  22 Nov 2019 09:55:32 GMT -->
</html>