@extends('layouts.OB_app')

@section('content')

<div class="auth-page">
    <div class="auth-card">

        <!-- IMAGE GAUCHE -->
        <div class="auth-image" style="background-image: url('/images/login.jpg');">
            <div class="auth-overlay">
                <h2>Hello Friend</h2>
                <p>To keep connected with us please login with your personal info</p>
                <a href="{{ route('register') }}" class="btn-outline">Sign up</a>
            </div>
        </div>

        <!-- FORM DROITE -->
        <div class="auth-form">
            <div class="auth-form-box">

                <h1>Event <span>Planner</span></h1>
                <h1>Sign In to Event Planner</h1>

                {{-- Affichage des erreurs --}}
                @if ($errors->any())
                    <div class="error-box">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="field">
                        <label for="email">YOUR EMAIL</label>
                        <input 
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="password">YOUR PASSWORD</label>
                        <input 
                            id="password"
                            type="password"
                            name="password"
                            required
                        >
                    </div>

                    <!-- FORGOT PASSWORD -->
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">
                            Forgot your password ?
                        </a>
                    </div>

                    <button type="submit" class="btn-primary" >Sign in</button>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection
