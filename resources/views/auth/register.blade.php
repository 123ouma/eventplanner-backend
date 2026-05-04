@extends('layouts.OB_app')

@section('content')

<div class="auth-page">
    <div class="auth-card">

        <!-- IMAGE GAUCHE -->
      <div class="auth-image" style="background-image: url('/images/registre.jpg');">
            <div class="auth-overlay">
                <h2>Welcome back</h2>
                <p>
                    To keep connected with us provide us with your information
                </p>
                <a href="{{ route('login') }}" class="btn-outline">
                    Signin
                </a>
            </div>
        </div>

        <!-- FORM DROITE -->
        <div class="auth-form">
            <div class="auth-form-box">

                <h1>Event <span>Planner</span></h1>
                <h1>Sign Up to Event Planner</h1>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="field">
                        <label for="name">YOUR NAME</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            placeholder="Enter your name"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="email">YOUR EMAIL</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            placeholder="Enter your email"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="password">PASSWORD</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >
                    </div>

                    <div class="field">
                        <label for="password_confirmation">
                            CONFIRM PASSWORD
                        </label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            placeholder="Enter your password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn-primary">
                        Sign Up
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
