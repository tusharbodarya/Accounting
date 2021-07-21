@extends('layouts.app')

@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="index.html" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft-primary">
                            <div class="row">
                                @if (session()->get('msg'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                        {{ session()->get('msg') }}

                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                @endif
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Register</h5>
                                        <p>Get your account now.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ 'assets/images/profile-img.png' }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="index.html">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ asset('assets/images/logo.svg') }}" alt="" class="rounded-circle"
                                                height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" action="{{ route('register') }}" method="POST">

                                    @if (Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    @if (Session::get('fail'))
                                        <div class="alert alert-danger">
                                            {{ Session::get('fail') }}
                                        </div>
                                    @endif

                                    @csrf
                                    <div class="form-group row">
                                        <label for="name">{{ __('Name') }}</label>

                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="email">{{ __('E-Mail Address') }}</label>

                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="gstno">{{ __('GSTIN No.') }}</label>

                                        <input id="gstno" type="text"
                                            class="form-control @error('gstno') is-invalid @enderror" name="gstno"
                                            value="{{ old('gstno') }}" required autocomplete="gstno">

                                        @error('gstno')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="bankname">{{ __('Bank Name') }}</label>

                                        <input id="bankname" type="text"
                                            class="form-control @error('bankname') is-invalid @enderror" name="bankname"
                                            value="{{ old('bankname') }}" required autocomplete="bankname">

                                        @error('bankname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="acno">{{ __('Bank A/C No.') }}</label>

                                        <input id="acno" type="text"
                                            class="form-control @error('acno') is-invalid @enderror" name="acno"
                                            value="{{ old('acno') }}" required autocomplete="acno">

                                        @error('acno')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="ifsc">{{ __('RTGS/IFSC Code ') }}</label>

                                        <input id="ifsc" type="text"
                                            class="form-control @error('ifsc') is-invalid @enderror" name="ifsc"
                                            value="{{ old('ifsc') }}" required autocomplete="ifsc">

                                        @error('ifsc')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="password">{{ __('Password') }}</label>

                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm">{{ __('Confirm Password') }}</label>

                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary btn-block waves-effect waves-light"
                                    type="submit">{{ __('Register') }}</button>
                            </div>
                            </form>
                            <div class="mt-5 text-center">

                                <div>
                                    <p>Already have an account ? <a href="{{ route('login') }}"
                                            class="font-weight-medium text-primary"> Login</a> </p>
                                    <p>© 2021 Accounting. Crafted by Tushar Bodarya</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
