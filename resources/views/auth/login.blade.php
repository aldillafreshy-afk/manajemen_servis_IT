<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="session-status">
            <i class="fas fa-check-circle"></i>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">
                Email <span class="required">*</span>
            </label>
            <div class="input-wrapper">
                <i class="fas fa-envelope"></i>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Masukkan alamat email"
                    required 
                    autofocus 
                    autocomplete="username"
                />
            </div>
            @error('email')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">
                Password <span class="required">*</span>
            </label>
            <div class="input-wrapper">
                <i class="fas fa-lock"></i>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    placeholder="Masukkan password"
                    required 
                    autocomplete="current-password"
                />
            </div>
            @error('password')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="form-options">
            <label class="remember-me">
                <input type="checkbox" name="remember" id="remember_me">
                <span>Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">
                    <i class="fas fa-key" style="font-size:12px;"></i> Lupa password?
                </a>
            @endif
        </div>

        <!-- Actions -->
        <div class="form-actions">
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
            
            <a href="{{ route('register') }}" class="btn-register">
                <i class="fas fa-user-plus"></i> Daftar
            </a>
        </div>
    </form>
</x-guest-layout>