<x-guest-layout>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">{{ __('Full Name') }}</label>
            <input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus placeholder="John Doe" />
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <input id="email" class="form-input" type="email" name="email" :value="old('email')" required placeholder="name@example.com" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-input"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="••••••••" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="form-input"
                            type="password"
                            name="password_confirmation" required 
                            placeholder="••••••••" />
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px;">
                {{ __('Create Account') }}
            </button>
        </div>
    </form>

    <div class="auth-footer">
        {{ __('Already registered?') }} 
        <a href="{{ route('login') }}">{{ __('Login Now') }}</a>
    </div>
</x-guest-layout>

