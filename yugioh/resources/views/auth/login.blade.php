@extends('layout.app')
@section('content')
<div class="card-body">
    <section class="login spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>{{ __('Login') }}</h3>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="input__item">
                                <input id="Username" type="text" class="form-control @error('Username') is-invalid @enderror" name="Username" value="{{ old('Username') }}" placeholder="Username" required autofocus>
                                <span class="fa fa-user icon_user"></span>
                                @error('Username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="input__item">
                                <div class="password-wrapper">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                                    <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" onclick="togglePasswordVisibility()"></span>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember" style="color: white;">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            <a href="{{ route('password.request') }}" class="forgot-password-link">{{ __('Forgot Password?') }}</a>
                            <button type="submit" class="site-btn">{{ __('Login Now') }}</button>
                        </form>

                        {{-- Display errors below the login form --}}
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert" style="margin-top: 10px;">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login__register">
                        <h3>{{ __("Don't Have An Account?") }}</h3>
                        <a href="{{ route('register') }}" class="primary-btn">{{ __('Register Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    // Toggle password visibility
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('password');
        var eyeIcon = document.querySelector('.toggle-password');

        if (passwordInput && eyeIcon) {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        } else {
            console.error('Element not found');
        }
    }
</script>
</div>
@endsection
