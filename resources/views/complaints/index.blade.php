@extends('layouts.app')
@section('title', 'My Complaints | BAUST')
@section('content')
    <div class="section-head">
        <div>
            <h1>My Complaints</h1>
            <p class="muted">Search your records, review attachments, and track the progress of each complaint.</p>
        </div>
        <a class="btn" href="{{ route('complaints.create') }}">＋ New Complaint</a>
    </div>

    <div class="card">
        <form class="filter" method="GET">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search reference or title" />
            <select name="status">
                <option value="">All statuses</option>
                @foreach (['Pending', 'In Progress', 'Resolved'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <button class="btn smallbtn" type="submit">Filter</button>
            <a href="{{ route('complaints.index') }}" class="small" style="margin-left: 4px">Clear</a>
        </form>

        @if ($complaints->isEmpty())
            <div class="empty">No matching complaints found.</div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Assigned Authority</th>
                            <th>Evidence</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($complaints as $complaint)
                            <tr>
                                <td><strong>{{ $complaint->reference_no }}</strong></td>
                                <td>{{ $complaint->title }}</td>
                                <td>{{ $complaint->category->name }}</td>
                                <td>{{ $complaint->assignee?->name ?? 'Not assigned' }}</td>
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
            <div class="pagination">{{ $complaints->links() }}</div>
        @endif
    </div>
@endsection
