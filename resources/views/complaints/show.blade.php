@extends('layouts.app')
@section('title', 'Complaint ' . $complaint->reference_no . ' | BAUST')
@section('content')
    <div class="section-head">
        <div>
            <p class="small" style="font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase">Complaint Details</p>
            <h1 style="font-size: 26px; margin-bottom: 6px">{{ $complaint->title }}</h1>
            <p class="muted">Reference No: <strong>{{ $complaint->reference_no }}</strong></p>
        </div>
        <span class="badge {{ $complaint->status_class }}" style="font-size: 13px; padding: 6px 14px">{{ $complaint->status }}</span>
    </div>

    <div class="two grid">
        <div class="card">
            <h2>Complaint Information</h2>
            <p><span class="muted small">Category</span><br /><strong>{{ $complaint->category->name }}</strong></p>
            <p><span class="muted small">Submitted Date</span><br />{{ $complaint->created_at->format('d M Y, h:i A') }}</p>
            <p>
                <span class="muted small">Incident Date</span><br />
                {{ $complaint->incident_date?->format('d M Y') ?? 'Not provided' }}
            </p>
            <p>
                <span class="muted small">Assigned University Authority</span><br />
                {{ $complaint->assignee?->name ?? 'Pending Assignment' }}
            </p>

            <hr style="border: 0; border-top: 1px solid var(--border); margin: 20px 0" />
            <h3>Description</h3>
            <p style="white-space: pre-line; line-height: 1.6">{{ $complaint->description }}</p>

            @if ($complaint->attachments->isNotEmpty())
                <hr style="border: 0; border-top: 1px solid var(--border); margin: 20px 0" />
                <h3 style="margin-bottom: 4px">Evidence Files & Attachments ({{ $complaint->attachments->count() }})</h3>
                <p class="muted small" style="margin-top: 0">Click any image to open full resolution preview in the modal lightbox.</p>
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

        <div class="card">
            <h2>Status & Administrative History</h2>
            <div class="timeline" style="margin-top: 18px">
                @forelse ($complaint->history as $event)
                    <div class="event">
                        <strong style="font-size: 15px">{{ $event->new_status }}</strong>
                        <div class="small" style="margin-top: 2px">
                            {{ $event->created_at->format('d M Y, h:i A') }}
                            @if ($event->administrator) · {{ $event->administrator->name }}@endif
                        </div>
                        <p style="margin: 8px 0 0; white-space: pre-line">{{ $event->remark ?: 'No remark provided.' }}</p>
                    </div>
                @empty
                    <p class="muted">No history recorded yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div style="margin-top: 18px">
        <a class="btn secondary" href="{{ route('complaints.index') }}">← Back to My Complaints</a>
    </div>
@endsection
