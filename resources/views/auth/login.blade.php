@extends('backend.layouts.master-without-nav')

@section('title', 'Login | DPMTSP Admin')

@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="{{ url('/') }}" class="text-reset"><i class="fas fa-home h2"></i></a>
    </div>

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="text-white font-size-20">Selamat Datang Kembali!</h5>
                                <p class="text-white-50 mb-0">Masuk untuk melanjutkan ke panel admin DPMTSP</p>
                                <a href="{{ url('/') }}" class="logo logo-admin mt-4 d-block">
                                    <img src="{{ asset('build/images/logo-sm-dark.png') }}" alt="DPMTSP" height="30">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">

                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                                            required autofocus>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Masukkan password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">Ingat saya</label>
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                                            Masuk
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <!-- <p>Belum punya akun? <a href="{{ route('register') }}" class="fw-medium text-primary"> Daftar sekarang</a></p> -->
                        <p>©
                            <script>document.write(new Date().getFullYear())</script> DPMTSP Katingan. All Rights Reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('build/js/app.js') }}"></script>
@endpush
