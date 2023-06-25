<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Login</title>

    {{-- <link rel="stylesheet" type="text/css" href="/css/style.css"> --}}
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .bg-standard {
            background: #f3e8d9;
        }

        .header {
            margin-bottom: -5.5%;
        }

        .kucing {
            margin-top: 20%;
        }

        .fluline {
            width: 12%;
            margin-top: 0%
        }

        .text-sidebar {
            color: #8b3327;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        .backLogin {
            margin-left: 43%;
        }

        @media (max-width: 768px) {
            .backLogin {
                margin-left: 20%;
            }
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }

        .login {
            background-color: #f9f5f0;
        }

        .btn-login {
            background-color: #8B3327;
            color: #F9F5F0;
        }

        .daftar {
            color: #8B3327;
        }

        .footer {
            margin-top: -0.25%;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</head>

<body class="login">
    <section class="vh-100">
        <div
            class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-3 px-3 px-xl-5 bg-standard header">

            <div class="text-sidebar text-center fw-bold mb-3 mb-md-0">
                <img src="/img/logo.png" class="img-fluid fluline" alt="Sample image">
            </div>

        </div>

        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    {{-- <img src="/img/logo.png" class="img-fluid" alt="Sample image" style="width:40%; margin-bottom:-20%; margin-top:10%; margin-left:140%"> --}}
                    <img src="/img/kucing.png" class="img-fluid kucing" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="forgot-password">
                        @csrf
                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fs-3 fw-bold mx-3 mb-0" style=color:#8B3327;>Lupa Password</p>
                        </div>
                        <div>
                            <input type="email" id="form3Example4" class="form-control form-control-lg" name="email"
                                placeholder="Masukan email " />
                            @error('email')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-outline mb-3">
                            <input type="password" id="form3Example4" class="form-control form-control-lg mt-2"
                                name="password" placeholder="Masukan password baru" />
                            {{-- <label class="form-label" for="form3Example4">Password</label> --}}
                        </div>
                        @error('password')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div>
                            <input type="password" class="form-control form-control-lg" name="password_confirmation"
                                id='password_confirmation' placeholder="Masukan Ulang password" />
                        </div>
                        @error('password_confirmation')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn-login border-0 rounded"
                                style="padding-left: 1rem; padding-right: 1rem; margin-top: -1rem;">Reset
                                Password</button>
                            <a href="/login" class="text-body backLogin">Back to Login</a>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Belum punya akun? <a href="/daftar"
                                    class="daftar">Daftar</a></p>
                        </div>
                        {{-- <span class=""> <a href="/login" class="text-body">Back to Login</a></span> --}}

                    </form>
                </div>
            </div>
        </div>
        <div
            class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-standard footer">
            <!-- Copyright -->
            <div class="text-sidebar text-center fw-bold mb-3 mb-md-0">
                Copyright © 2023
            </div>
            <!-- Copyright -->
        </div>
    </section>
    {{-- @include('sweetalert::alert') --}}
</body>

</html>
