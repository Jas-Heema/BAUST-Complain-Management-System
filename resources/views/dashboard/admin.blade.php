@extends('layouts.app')
@section('title', 'Administrator Dashboard | BAUST')
@section('content')
    <div class="section-head">
        <div>
            <p class="small" style="font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase">
                ADMINISTRATIVE PORTAL · {{ strtoupper(str_replace('_', ' ', auth()->user()->role)) }}
            </p>
            <h1 style="margin-bottom: 4px">Complaint Overview</h1>
            <p class="muted">Review and manage complaints assigned to your department or authority.</p>
        </div>
        <a class="btn" href="{{ route('admin.complaints.index') }}">View Assigned Complaints</a>
    </div>

    <div class="grid">
        <div class="stat"><span>Total Assigned</span><strong>{{ $counts['total'] }}</strong></div>
        <div class="stat"><span>Pending</span><strong>{{ $counts['pending'] }}</strong></div>
        <div class="stat"><span>In Progress</span><strong>{{ $counts['progress'] }}</strong></div>
        <div class="stat"><span>Resolved</span><strong>{{ $counts['resolved'] }}</strong></div>
    </div>

    <div class="card" style="margin-top: 24px">
        <div class="section-head">
            <h2 style="margin: 0">Recently Submitted Complaints</h2>
            <a href="{{ route('admin.complaints.index') }}">View All →</a>
        </div>
        @if ($complaints->isEmpty())
            <div class="empty">No complaints are currently assigned to this authority.</div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Student</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Evidence</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($complaints as $complaint)
                            <tr>
                                <td><strong>{{ $complaint->reference_no }}</strong></td>
                                <td>
                                    {{ $complaint->student->name }}<br />
                                    <span class="small">{{ $complaint->student->student_id }}</span>
                                </td>
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
                                <td><a class="btn smallbtn secondary" href="{{ route('admin.complaints.show', $complaint) }}">Review</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
