@extends('layouts.app')
@section('title', 'Submit a Complaint | BAUST')
@section('content')
    <div style="max-width: 820px; margin: 0 auto">
        <div class="section-head">
            <div>
                <h1>Submit a Complaint</h1>
                <p class="muted">
                    Provide accurate details and evidence so the appropriate university authority can review and resolve your concern.
                </p>
            </div>
            <a class="btn smallbtn outline" href="{{ route('complaints.index') }}">My Complaints</a>
        </div>

        <div class="card">
            <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="field">
                    <label for="title">Complaint Title *</label>
                    <input
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        required
                        maxlength="180"
                        placeholder="Brief summary of your concern (e.g. Lab equipment issue in Room 302)"
                    />
                </div>

                <div class="field">
                    <label for="category_id">Category *</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="small" style="margin-top: 4px">Your selected category automatically routes the complaint to the responsible university authority.</p>
                </div>

                <div class="field">
                    <label for="description">Detailed Description *</label>
                    <textarea
                        id="description"
                        name="description"
                        required
                        minlength="10"
                        maxlength="10000"
                        placeholder="Explain what happened, location, timing, and any relevant circumstances."
                    >{{ old('description') }}</textarea>
                </div>

                <div class="field">
                    <label for="incident_date">Incident Date (Optional)</label>
                    <input
                        id="incident_date"
                        type="date"
                        name="incident_date"
                        value="{{ old('incident_date') }}"
                        max="{{ date('Y-m-d') }}"
                    />
                </div>

                <div class="field">
                    <label for="attachments">Supporting Evidence & Files (Optional)</label>
                    <input id="attachments" type="file" name="attachments[]" multiple accept=".jpg,.jpeg,.png,.pdf" />
                    <p class="small" style="margin-top: 4px">Allowed file formats: JPG, PNG, PDF. Maximum file size: 5 MB each. You can select multiple files.</p>
                </div>

                <div style="display: flex; gap: 10px; align-items: center; margin-top: 24px">
                    <button class="btn" type="submit">Submit Complaint</button>
                    <a class="btn secondary" href="{{ route('dashboard') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
