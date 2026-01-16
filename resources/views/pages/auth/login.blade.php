<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Finance - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    {{-- @if ($errors->any())
        @dd($errors->all())
    @endif --}}
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9 col-md-10">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
                                <div class="text-center px-4">
                                    <img src="{{ asset('img/samaji.png') }}" style="max-width:150px;">
                                    <h4 class="font-weight-bold mt-3">SAMAJI Finance</h4>
                                    <p class="text-muted small">
                                        Sistem manajemen keuangan terintegrasi
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h3 font-weight-bold text-gray-900 mb-2">
                                            Welcome Back
                                        </h1>
                                        <p class="text-muted mb-4">
                                            Login untuk mengelola keuangan Anda
                                        </p>
                                    </div>
                                    <form class="user" action="/login" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="InputEmail" name="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="InputPassword" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block"> Login </button>

                                    </form>
                                    {{-- <hr> --}}
                                    {{-- <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div> --}}
                                    {{-- <div class="text-center">
                                        <a class="small" href="/">Create an Account!</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>
    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #224abe);
        }
        .card {
            border-radius: 18px;
        }
    </style>

</body>

</html>