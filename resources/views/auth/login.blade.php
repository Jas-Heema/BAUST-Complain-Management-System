@extends('layouts.app')
@section('title', 'Log In | BAUST Complaints')
@section('content')
    <div style="max-width: 480px; margin: 30px auto">
        <div class="card">
            <h1 style="font-size: 26px; margin-bottom: 6px">Welcome Back</h1>
            <p class="muted" style="margin-top: 0; margin-bottom: 20px">Log in to the BAUST Complaint Management Portal.</p>
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="field">
                    <label for="email">Official Email Address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="e.g. student@baust.edu.bd"
                    />
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" />
                </div>
                <label class="small" style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer">
                    <input type="checkbox" name="remember" value="1" /> Remember me on this device
                </label>
                <button class="btn" style="width: 100%; margin-top: 18px" type="submit">Log In</button>
            </form>
            <a class="btn secondary" style="width: 100%; margin-top: 12px" href="{{ route('password.request') }}">
                Forgot Password?
            </a>
            <p class="small" style="margin-top: 18px; text-align: center">
                New student? <a href="{{ route('register') }}">Create an account here</a>.
            </p>
        </div>
    </div>
@endsection
