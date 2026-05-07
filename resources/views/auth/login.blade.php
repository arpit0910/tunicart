<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus placeholder="name@example.com" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label for="password" class="form-label" style="margin-bottom: 0;">{{ __('Password') }}</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 0.8rem; color: var(--primary-color);">
                        {{ __('Forgot?') }}
                    </a>
                @endif
            </div>
            <input id="password" class="form-input"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="••••••••" />
        </div>

        <!-- Remember Me -->
        <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
            <input id="remember_me" type="checkbox" name="remember" style="accent-color: var(--primary-color); width: 16px; height: 16px; cursor: pointer;">
            <label for="remember_me" style="font-size: 0.85rem; color: var(--text-light); cursor: pointer;">{{ __('Keep me logged in') }}</label>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px;">
                {{ __('Login to Account') }}
            </button>
        </div>
    </form>

    <div class="auth-footer">
        {{ __("Don't have an account?") }} 
        <a href="{{ route('register') }}">{{ __('Sign Up Free') }}</a>
    </div>
</x-guest-layout>

