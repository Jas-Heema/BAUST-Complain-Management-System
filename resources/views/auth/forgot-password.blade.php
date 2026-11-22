@extends('layouts.app')
@section('title', 'Forgot Password | BAUST')
@section('content')
    <div style="max-width: 480px; margin: 30px auto">
        <div class="card">
            <h1 style="font-size: 26px; margin-bottom: 6px">Reset Your Password</h1>
            <p class="muted" style="margin-top: 0; margin-bottom: 20px">Enter your official university email and we will send you a password reset link.</p>
            <form method="POST" action="{{ route('password.email') }}">
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
                        autocomplete="email"
                        placeholder="e.g. user@baust.edu.bd"
                    />
                </div>
                <button class="btn" style="width: 100%; margin-top: 10px" type="submit">Email Password Reset Link</button>
            </form>
            <p class="small" style="margin-top: 20px; text-align: center">
                Remember your password? <a href="{{ route('login') }}">Return to Log In</a>.
            </p>
        </div>
    </div>
@endsection
