@extends('layouts.app')
@section('title', 'BAUST Complaint Management System')
@section('content')
    <section class="hero">
        <p class="small" style="font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase">
            Bangladesh Army University of Science and Technology
        </p>
        <h1 style="font-size: 32px; margin-top: 8px; margin-bottom: 12px">A clearer way to raise, route, and resolve campus concerns.</h1>
        <p class="muted" style="max-width: 680px; font-size: 16px; line-height: 1.6">
            Submit university-related complaints through one centralized platform. Upload evidence, track status in real-time,
            and review administrative remarks with your unique reference number.
        </p>
        <div class="inline" style="margin-top: 24px; flex-wrap: wrap">
            @guest
                <a class="btn" href="{{ route('register') }}">Create Student Account</a>
                <a class="btn secondary" href="{{ route('login') }}">Log In</a>
            @else
                <a class="btn" href="{{ route('dashboard') }}">Open Dashboard</a>
            @endguest
        </div>
    </section>

    <div class="two grid">
        <div class="card">
            <h3 style="color: var(--c-cornflower-blue)">01 · Submit</h3>
            <p class="muted">Provide details, category, date, and upload supporting photos or documents as evidence.</p>
        </div>
        <div class="card">
            <h3 style="color: var(--c-cornflower-blue)">02 · Route</h3>
            <p class="muted">Your complaint is automatically assigned to the responsible department head or provost.</p>
        </div>
        <div class="card">
            <h3 style="color: var(--c-cornflower-blue)">03 · Track</h3>
            <p class="muted">Check real-time status updates and notifications directly on your student dashboard.</p>
        </div>
        <div class="card">
            <h3 style="color: var(--c-cornflower-blue)">04 · Resolve</h3>
            <p class="muted">Designated university authorities investigate, take corrective action, and post remarks.</p>
        </div>
    </div>
@endsection
