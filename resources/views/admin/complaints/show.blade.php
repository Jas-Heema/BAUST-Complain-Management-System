@extends('layouts.app')
@section('title', 'Review Complaint ' . $complaint->reference_no . ' | BAUST')
@section('content')
    <div class="section-head">
        <div>
            <p class="small" style="font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase">Complaint Review</p>
            <h1 style="font-size: 26px; margin-bottom: 6px">{{ $complaint->title }}</h1>
            <p class="muted">Reference No: <strong>{{ $complaint->reference_no }}</strong></p>
        </div>
        <span class="badge {{ $complaint->status_class }}" style="font-size: 13px; padding: 6px 14px">{{ $complaint->status }}</span>
    </div>

    <div class="two grid">
        <div class="card">
            <h2>Complaint Details</h2>
            <p>
                <span class="muted small">Student Name & ID</span><br />
                <strong>{{ $complaint->student->name }}</strong>
                ({{ $complaint->student->student_id }})
            </p>
            <p><span class="muted small">Department</span><br />{{ $complaint->student->department ?? 'Not provided' }}</p>
            <p><span class="muted small">University Email</span><br />{{ $complaint->student->email }}</p>
            <p><span class="muted small">Category</span><br /><strong>{{ $complaint->category->name }}</strong></p>
            <p><span class="muted small">Submitted Date</span><br />{{ $complaint->created_at->format('d M Y, h:i A') }}</p>

            <hr style="border: 0; border-top: 1px solid var(--border); margin: 20px 0" />
            <h3>Description</h3>
            <p style="white-space: pre-line; line-height: 1.6">{{ $complaint->description }}</p>

            @if ($complaint->attachments->isNotEmpty())
                <hr style="border: 0; border-top: 1px solid var(--border); margin: 20px 0" />
                <h3 style="margin-bottom: 4px">Submitted Evidence & Attachments ({{ $complaint->attachments->count() }})</h3>
                <p class="muted small" style="margin-top: 0">Click any image to view full size in the Day/Night modal lightbox.</p>
                <div class="attachment-grid">
                    @foreach ($complaint->attachments as $attachment)
                        <div class="attachment-card">
                            @if ($attachment->isImage())
                                <div
                                    class="attachment-img-preview-box"
                                    data-lightbox-src="{{ $attachment->url }}"
                                    data-lightbox-title="{{ $attachment->original_name }} ({{ $complaint->reference_no }})"
                                    data-lightbox-download="{{ route('attachments.download', $attachment) }}"
                                    title="Click to expand full resolution image"
                                >
                                    <img src="{{ $attachment->url }}" alt="{{ $attachment->original_name }}" loading="lazy" />
                                    <div class="attachment-img-overlay">
                                        <span>🔍 Expand Preview</span>
                                    </div>
                                </div>
                            @else
                                <div class="attachment-doc-preview-box">
                                    <span class="attachment-doc-icon">📄</span>
                                    <span class="badge" style="background: var(--c-cornflower-blue); color: var(--c-midnight-navy)">{{ $attachment->extension ?: 'DOCUMENT' }}</span>
                                </div>
                            @endif
                            <div class="attachment-card-body">
                                <div>
                                    <div class="attachment-name" title="{{ $attachment->original_name }}">{{ $attachment->original_name }}</div>
                                    <div class="attachment-meta">
                                        <span>{{ $attachment->formatted_size }}</span>
                                        <span>{{ $attachment->extension }}</span>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 6px; margin-top: 8px">
                                    @if ($attachment->isImage())
                                        <button
                                            type="button"
                                            class="btn smallbtn outline"
                                            style="flex: 1"
                                            data-lightbox-src="{{ $attachment->url }}"
                                            data-lightbox-title="{{ $attachment->original_name }} ({{ $complaint->reference_no }})"
                                            data-lightbox-download="{{ route('attachments.download', $attachment) }}"
                                        >
                                            Preview
                                        </button>
                                    @endif
                                    <a class="btn smallbtn secondary" style="flex: 1" href="{{ route('attachments.download', $attachment) }}">
                                        Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <div class="card">
                <h2>Update Complaint Status</h2>
                <form method="POST" action="{{ route('admin.complaints.update', $complaint) }}">
                    @csrf
                    @method('PATCH')
                    <div class="field">
                        <label for="status">New Status</label>
                        <select name="status" id="status" required>
                            @foreach (['Pending', 'In Progress', 'Resolved'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $complaint->status) === $status)>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="remark">Administrative Remark *</label>
                        <textarea
                            id="remark"
                            name="remark"
                            required
                            minlength="3"
                            maxlength="3000"
                            placeholder="Describe actions taken, investigations conducted, or next steps for the student."
                        >{{ old('remark') }}</textarea>
                    </div>
                    <button class="btn" type="submit">Save Update</button>
                </form>
            </div>

            <div class="card" style="margin-top: 20px">
                <h2>Resolution & History</h2>
                <div class="timeline" style="margin-top: 18px">
                    @forelse ($complaint->history as $event)
                        <div class="event">
                            <strong style="font-size: 15px">{{ $event->new_status }}</strong>
                            <div class="small" style="margin-top: 2px">
                                {{ $event->created_at->format('d M Y, h:i A') }}
                                @if ($event->administrator) · {{ $event->administrator->name }}@endif
                            </div>
                            <p style="margin: 8px 0 0; white-space: pre-line">{{ $event->remark ?: 'No remark.' }}</p>
                        </div>
                    @empty
                        <p class="muted">No history recorded.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 18px">
        <a class="btn secondary" href="{{ route('admin.complaints.index') }}">← Back to Assigned Complaints</a>
    </div>
@endsection
