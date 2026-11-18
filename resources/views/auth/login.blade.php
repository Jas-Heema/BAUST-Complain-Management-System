@extends('layouts.app')
@section('title', 'Log in')
@section('content')
    <div class="auth-shell">
        <div class="card auth-card">
            <div class="auth-header">
                <div class="auth-icon" aria-hidden="true">B</div>
                <h1>Welcome back</h1>
            </div>
            <p class="muted">Log in to the BAUST Complaint Management System.</p>
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="field">
                    <label for="email">Email address</label
                    ><input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                    />
                </div>
                <div class="field">
                    <label for="password">Password</label
                    ><input id="password" type="password" name="password" required autocomplete="current-password" />
                </div>
                <label class="small"><input type="checkbox" name="remember" value="1" /> Remember me</label>
                <button class="btn" style="width: 100%; margin-top: 18px" type="submit">Log in</button>
            </form>
            <p class="small" style="margin-top: 18px">
                Student account needed? <a href="{{ route('register') }}">Register here</a>.
            </p>
        </div>
    </div>
@endsection
