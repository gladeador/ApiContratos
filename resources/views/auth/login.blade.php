<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />
@include('layouts.css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--Mi Estilo particulas-->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

</head>

<body class="hold-transition login-page">
    <div id="particles-js"></div>
    <div class="contenedor login-box">
        <div class="login-logo">
            <img src="{{ asset('img/Logo-Valuetech.svg') }}" class="img-responsive">
        </div>
        <!-- /.login-logo -->

        <!-- /.login-box-body -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Ingreso al Sistema</p>

                <form method="post" action="{{ url('/login') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                            class="form-control @error('email') is-invalid @enderror">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                        @error('email')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" placeholder="Password"
                            class="form-control @error('password') is-invalid @enderror">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">Recuerdame</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                        </div>

                    </div>
                </form>
                <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-dark">
                        <i class="fab fa-microsoft mr-2"></i> Iniciar Sesión con Oficce 365
                    </a>
                    <a href="#" class="btn btn-block btn-info">
                        <i class="fab fa-microsoft mr-2"></i> Iniciar Sesión con Oficce 365
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-microsoft mr-2"></i> Iniciar Sesión con Oficce 365
                    </a>
                    <a href="#" class="btn btn-block btn-link">
                        <i class="fab fa-microsoft mr-2"></i> Iniciar Sesión con Oficce 365
                    </a>
                </div>
                <p class="mb-1">
                    <a href="{{ route('password.request') }}">Olvide mi Password</a>
                </p>
                {{--  <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
                </p> --}}
            </div>
            <!-- /.login-card-body -->
        </div>

    </div>
    <!-- /.login-box -->

    <!--js Particles-->
    <script src="{{ asset('js/particles.min.js') }}"></script>
    <script src="{{ asset('js/apparticles.js') }}"></script>

</body>

</html>