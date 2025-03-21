<!-- resources/views/auth/forgot-password.blade.php -->
@extends('layout.app')
@section('content')
<div class="card-body">
    <section class="login spad">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login__form">
                        <h3>{{ __('Reset Password') }}</h3>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="input__item">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required>
                                <span class="fas fa-envelope field-icon"></span>
                            </div>

                            <button type="submit" class="site-btn">{{ __('Check Email') }}</button>

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

