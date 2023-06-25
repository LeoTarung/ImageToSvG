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
            background: #dadff5;
        }

        .bg-standard {
            background: #eef7fc;
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
            color: #27478b;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }

        .login {
            background-color: #e7fcfd;
        }

        .btn-login {
            background-color: #27478b;
            color: #F9F5F0;
        }

        .daftar {
            color: #27478b;
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

                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form action="/login/masuk" method="post">
                        @csrf
                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fs-3 fw-bold mx-3 mb-0" style=color:#27478b;>Login</p>
                        </div>

                        @error('email')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="form3Example3" name="email" class="form-control form-control-lg"
                                placeholder="Masukan email anda" required />
                            {{-- <label class="form-label" for="form3Example3">Email address</label> --}}
                        </div>


                        @error('password')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <input type="password" id="form3Example4" name="password"
                                class="form-control form-control-lg" placeholder="Masukan password" required />
                            {{-- <label class="form-label" for="form3Example4">Password</label> --}}
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">
                                <input class="form-check-input me-2" type="checkbox" value=""
                                    id="form2Example3" />
                                <label class="form-check-label" for="form2Example3">
                                    Remember me
                                </label>
                            </div>
                            <a href="forgot-password" class="text-body">Lupa Password?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn-login border-0 rounded"
                                style="padding-left: 2.5rem; padding-right: 2.5rem; margin-top: -1rem;">Login</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Belum punya akun? <a href="/daftar"
                                    class="daftar">Daftar</a></p>
                        </div>

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
