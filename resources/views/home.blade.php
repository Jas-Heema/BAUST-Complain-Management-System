@extends('layouts.app')
@section('title', 'BAUST Complaint Management System')
@section('content')
    <section class="hero">
        <p class="small" style="font-weight: 800; letter-spacing: 0.12em; color: #315d9b">
            BANGLADESH ARMY UNIVERSITY OF SCIENCE AND TECHNOLOGY
        </p>
        <h1 style="max-width: 700px">A clearer way to raise and track complaints.</h1>
        <p class="muted" style="max-width: 650px; font-size: 16px">
            Submit university-related concerns through one organized platform. Follow progress, review administrative
            remarks, and keep your complaint reference number in one place.
        </p>
        <div class="inline" style="margin-top: 22px; flex-wrap: wrap">
            @guest
                <a class="btn" href="{{ route('register') }}">Create student account</a
                ><a class="btn secondary" href="{{ route('login') }}">Log in</a>
            @else
                <a class="btn" href="{{ route('dashboard') }}">Open dashboard</a>
            @endguest
        </div>
    </section>
    <div class="two grid">
        <div class="card">
            <div class="step-mark" aria-hidden="true">01</div>
            <h3>Submit</h3>
            <p class="muted">Provide a title, description, category, incident date, and optional evidence.</p>
        </div>
        <div class="card">
            <div class="step-mark" aria-hidden="true">02</div>
            <h3>Route</h3>
            <p class="muted">Your complaint is assigned to the responsible university authority by category.</p>
        </div>
        <div class="card">
            <div class="step-mark" aria-hidden="true">03</div>
            <h3>Track</h3>
            <p class="muted">Use your unique reference number and dashboard to check the current status.</p>
        </div>
        <div class="card">
            <div class="step-mark" aria-hidden="true">04</div>
            <h3>Resolve</h3>
            <p class="muted">Authorized administrators record status updates and remarks in the complaint history.</p>
        </div>
    </div>
@endsection
