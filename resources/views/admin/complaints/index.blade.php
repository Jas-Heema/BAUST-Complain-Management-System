@extends('layouts.app')
@section('title', 'Assigned Complaints | BAUST')
@section('content')
    <div class="section-head">
        <div>
            <p class="small" style="font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase">Administration</p>
            <h1>Assigned Complaints</h1>
            <p class="muted">Complaints routed to your administrative authority are listed below.</p>
        </div>
    </div>

    <div class="card">
        <form class="filter" method="GET">
            <input
                type="search"
                name="q"
                value="{{ request('q') }}"
                placeholder="Reference, title, student ID or name"
            />
            <select name="status">
                <option value="">All statuses</option>
                @foreach (['Pending', 'In Progress', 'Resolved'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <select name="category_id">
                <option value="">All categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button class="btn smallbtn" type="submit">Filter</button>
            <a class="small" style="margin-left: 4px" href="{{ route('admin.complaints.index') }}">Clear</a>
        </form>

        @if ($complaints->isEmpty())
            <div class="empty">No complaints found matching the selected filters.</div>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Student</th>
                            <th>Complaint Title</th>
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
                                <td>{{ $complaint->created_at->format('d M Y') }}</td>
                                <td><a class="btn smallbtn secondary" href="{{ route('admin.complaints.show', $complaint) }}">Review</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination">{{ $complaints->links() }}</div>
        @endif
    </div>
@endsection
