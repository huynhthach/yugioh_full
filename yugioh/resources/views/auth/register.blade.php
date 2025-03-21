@extends('layout.app')
@section('content')
<div class="card-body">
    <section class="login spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>{{ __('Register') }}</h3>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="input__item">
                                <input id="Username" type="text" class="form-control @error('Username') is-invalid @enderror" name="Username" value="{{ old('Username') }}" placeholder="Username" required autofocus>
                                <span class="fa fa-user icon_user"></span>
                            </div>

                            <div class="input__item">
                                <input id="Email" type="email" class="form-control @error('Email') is-invalid @enderror" name="Email" value="{{ old('Email') }}" placeholder="Email" required>
                                <span class="fas fa-envelope field-icon"></span>
                            </div>

                            <div class="input__item">
                                <div class="password-wrapper">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                                    <span id="password-icon" toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" onclick="togglePasswordVisibility('#password')"></span>
                                </div>
                            </div>

                            <div class="input__item">
                                <div class="password-wrapper">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                                    <span id="password-confirm-icon" toggle="#password-confirm" class="fa fa-fw fa-eye field-icon toggle-password" onclick="togglePasswordVisibility('#password-confirm')"></span>
                                </div>
                            </div>


                            <button type="submit" class="site-btn">{{ __('Register Now') }}</button>

                            {{-- Display errors below the submit button --}}
                            @if (count($errors) > 0)
                                <div role="alert">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    // Toggle password visibility
    function togglePasswordVisibility(targetId) {
        var passwordInput = document.querySelector(targetId);
        var eyeIcon = document.querySelector(targetId + '-icon');

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
