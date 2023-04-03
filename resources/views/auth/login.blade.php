<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Spare Part System</title>
    <!-- Styles -->
    <link href="{{ asset('assets/css/main/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/Logo Taci White.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/Logo Taci White.png') }}" type="image/png">
</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-6 col-12">
                <div id="auth-left">
                    <div class="card">
                        <a href="{{ route('home') }}"><img class="rounded mx-auto d-block"
                                src="{{ asset('assets/images/logo/logo.png') }}" width="160" alt="Logo"></a>
                    </div>
                    <center>
                        <h1>Spare Part Repair</h1>

                        <p>Silahkan Login menggunakan NPK anda</p>
                    </center>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" id="NPK" name="NPK"
                                class="form-control form-control-xl @if ($errors->has('NPK')) is-invalid @endif"
                                placeholder="NPK" value="{{ old('NPK') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="invalid-feedback">
                                @error('NPK')
                                    <span class="text-danger" role="alert">
                                        <strong>NPK yang anda masukkan salah</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" id="password" name="password" class="form-control form-control-xl"
                                placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>


                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault"
                                name="remember">
                            <label class="form-check-label text-gray-600" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        <button type="submit"
                            class="btn btn-primary btn-block btn-lg shadow-lg mt-5">{{ __('Login') }}</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-5">
                        <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}"
                                class="font-bold">Signup</a>.</p>
                        {{-- <p><a class="font-bold" href="{{ url('/password/reset') }}">Forgot password?</a>.</p> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
</body>

</html>
