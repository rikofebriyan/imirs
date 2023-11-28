<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registration - Spare Part System</title>
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

                <div id="auth-left" class="py-3">
                    <a href="{{ route('login') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                    <div class="card">
                        <a href="{{ route('home') }}"><img class="rounded mx-auto d-block"
                                src="{{ asset('assets/images/logo/logo.png') }}" width="160" alt="Logo"></a>
                    </div>
                    <center>
                        <h1>Registration</h1>

                        <p>Silahkan Registrasi menggunakan NPK anda</p>
                    </center>
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            <strong>{{ session('error') }}</strong>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('submit-register') }}">
                        @csrf


                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" id="name" name="name"
                                class="form-control form-control-xl @error('name') is-invalid @enderror"
                                placeholder="Nama" value="{{ old('name') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>


                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" id="NPK" name="NPK"
                                class="form-control form-control-xl @error('NPK') is-invalid @enderror"
                                placeholder="NPK" value="{{ old('NPK') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            @error('NPK')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <select type="text" id="jabatan" name="jabatan"
                                class="form-control form-control-xl @error('jabatan') is-invalid @enderror"
                                placeholder="Jabatan">
                                <option value="">Pilih Role</option>
                                <option value="Facility" @if ($errors->first('jabatan') == 'Facility') selected @endif>
                                    Facility</option>
                                <option value="Maintenance" @if ($errors->first('jabatan') == 'Maintenance') selected @endif>
                                    Maintenance</option>
                                <option value="RepairMan" @if ($errors->first('jabatan') == 'RepairMan') selected @endif>RepairMan
                                </option>
                                <option value="Supervisor" @if ($errors->first('jabatan') == 'Supervisor') selected @endif>Supervisor
                                </option>
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-c-circle"></i>
                            </div>

                            @error('jabatan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" id="email" name="email"
                                class="form-control form-control-xl @error('email') is-invalid @enderror"
                                placeholder="Email" value="{{ old('email') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope-heart"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" id="password" name="password"
                                class="form-control form-control-xl @error('password') is-invalid @enderror"
                                placeholder="Password" value="{{ old('password') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-key"></i>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" id="password_confirm" name="password_confirmation"
                                class="form-control form-control-xl @error('password_confirmation') is-invalid @enderror"
                                placeholder="Konfirmasi Password" value="{{ old('password_confirmation') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-key"></i>
                            </div>
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">
                                {{ __('Register') }}</button>
                        </div>


                    </form>
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
