@extends('layouts.app')
@section('title', 'Student Registration | BAUST')
@section('content')
    <div style="max-width: 660px; margin: 25px auto">
        <div class="card">
            <h1 style="font-size: 26px; margin-bottom: 6px">Student Account Registration</h1>
            <p class="muted" style="margin-top: 0; margin-bottom: 20px">Register with your BAUST student credentials to submit and track complaints.</p>
            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="form-grid">
                    <div class="field">
                        <label for="student_id">Student ID *</label>
                        <input
                            id="student_id"
                            name="student_id"
                            value="{{ old('student_id') }}"
                            required
                            maxlength="50"
                            placeholder="e.g. 200101001"
                        />
                    </div>
                    <div class="field">
                        <label for="name">Full Name *</label>
                        <input id="name" name="name" value="{{ old('name') }}" required maxlength="120" placeholder="e.g. Sadia Islam" />
                    </div>
                    <div class="field">
                        <label for="department">Department *</label>
                        <input
                            id="department"
                            name="department"
                            value="{{ old('department', 'CSE') }}"
                            required
                            maxlength="120"
                            placeholder="e.g. CSE, EEE, ME, IPE, BBA, English"
                        />
                    </div>
                    <div class="field">
                        <label for="email">University Email *</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="e.g. student@baust.edu.bd" />
                    </div>
                    <div class="field">
                        <label for="password">Password *</label>
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
                        <label for="password_confirmation">Confirm Password *</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        />
                    </div>
                </div>
                <div style="margin-top: 18px">
                    <button class="btn" style="width: 100%" type="submit">Create Account</button>
                </div>
            </form>
            <p class="small" style="margin-top: 18px; text-align: center">
                Already registered? <a href="{{ route('login') }}">Log in here</a>.
            </p>
        </div>
    </div>
@endsection
