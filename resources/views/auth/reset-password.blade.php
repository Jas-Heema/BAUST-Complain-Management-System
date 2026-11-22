@extends('layouts.app')
@section('title', 'Set New Password | BAUST')
@section('content')
    <div style="max-width: 480px; margin: 30px auto">
        <div class="card">
            <h1 style="font-size: 26px; margin-bottom: 6px">Set a New Password</h1>
            <p class="muted" style="margin-top: 0; margin-bottom: 20px">Choose a secure new password for your account.</p>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}" />
                <div class="field">
                    <label for="email">Official Email Address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $email) }}"
                        required
                        autofocus
                        autocomplete="email"
                    />
                </div>
                <div class="field">
                    <label for="password">New Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                    />
                </div>
                <div class="field">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        minlength="8"
                        autocomplete="new-password"
                    />
                </div>
                <button class="btn" style="width: 100%; margin-top: 10px" type="submit">Change Password</button>
            </form>
        </div>
    </div>
@endsection
