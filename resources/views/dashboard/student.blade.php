@extends('layouts.app')
@section('title', 'Student Dashboard | BAUST')
@section('content')
    <div class="section-head">
        <div>
            <p class="small" style="font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase">Student Portal</p>
            <h1 style="margin-bottom: 4px">Hello, {{ auth()->user()->name }}</h1>
            <p class="muted">Here is the latest overview of your complaints and administrative updates.</p>
        </div>
        <a class="btn" href="{{ route('complaints.create') }}">＋ Submit New Complaint</a>
    </div>

    <div class="grid">
        <div class="stat"><span>Total Complaints</span><strong>{{ $counts['total'] }}</strong></div>
        <div class="stat"><span>Pending</span><strong>{{ $counts['pending'] }}</strong></div>
        <div class="stat"><span>In Progress</span><strong>{{ $counts['progress'] }}</strong></div>
        <div class="stat"><span>Resolved</span><strong>{{ $counts['resolved'] }}</strong></div>
    </div>

    <div class="card" style="margin-top: 24px">
        <div class="section-head">
            <h2 style="margin: 0">Recent Complaints</h2>
            <a href="{{ route('complaints.index') }}">View All →</a>
        </div>
        @if ($complaints->isEmpty())
            <div class="empty">
                You have not submitted any complaints yet.<br />
                <a class="btn smallbtn" style="margin-top: 14px" href="{{ route('complaints.create') }}">Submit your first complaint</a>
            </div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Evidence</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($complaints as $complaint)
                            <tr>
                                <td><strong>{{ $complaint->reference_no }}</strong></td>
                                <td>{{ $complaint->title }}</td>
                                <td>{{ $complaint->category->name }}</td>
                                <td>
                                    @if ($complaint->attachments->isNotEmpty())
                                        <div class="evidence-cell">
                                            @php $firstImage = $complaint->firstImageAttachment(); @endphp
                                            @if ($firstImage)
                                                <button
                                                    class="evidence-thumb-btn"
                                                    type="button"
                                                    data-lightbox-src="{{ $firstImage->url }}"
                                                    data-lightbox-title="{{ $firstImage->original_name }} ({{ $complaint->reference_no }})"
                                                    data-lightbox-download="{{ route('attachments.download', $firstImage) }}"
                                                    title="Click to preview: {{ $firstImage->original_name }}"
                                                >
                                                    <img class="evidence-thumb-img" src="{{ $firstImage->url }}" alt="{{ $firstImage->original_name }}" loading="lazy" />
                                                </button>
                                            @else
                                                @php $firstDoc = $complaint->attachments->first(); @endphp
                                                <a class="evidence-doc-link" href="{{ route('attachments.download', $firstDoc) }}" title="{{ $firstDoc->original_name }}">
                                                    📄 {{ $firstDoc->extension ?: 'FILE' }}
                                                </a>
                                            @endif
                                            @if ($complaint->attachments->count() > 1)
                                                <span class="evidence-more-badge" title="{{ $complaint->attachments->count() }} attachments">+{{ $complaint->attachments->count() - 1 }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="muted" style="font-size: 12px">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $complaint->status_class }}">{{ $complaint->status }}</span>
                                </td>
                                <td>{{ $complaint->created_at->format('d M Y') }}</td>
                                <td><a class="btn smallbtn secondary" href="{{ route('complaints.show', $complaint) }}">Details</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="card" style="margin-top: 20px">
        <h2>Recent Updates & Notifications</h2>
        @forelse ($notifications as $notification)
            <p style="border-bottom: 1px solid var(--border); padding: 10px 0; margin: 0">
                {{ $notification->message }}
                <span class="small" style="margin-left: 6px">· {{ $notification->created_at->diffForHumans() }}</span>
            </p>
        @empty
            <p class="muted" style="margin: 6px 0">No updates yet. When an administrator updates your complaint status, it will appear here.</p>
        @endforelse
    </div>
@endsection
