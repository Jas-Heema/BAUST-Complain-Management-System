@extends('layouts.app')
@section('title', 'Category Settings | BAUST')
@section('content')
    <div class="section-head">
        <div>
            <p class="small" style="font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase">System Configuration</p>
            <h1>Complaint Categories</h1>
            <p class="muted">Manage categories and configure which authority automatically receives complaints.</p>
        </div>
    </div>

    <div class="two grid">
        <div class="card">
            <h2>Add New Category</h2>
            <form method="POST" action="{{ route('superadmin.categories.store') }}">
                @csrf
                <div class="field">
                    <label for="cat-name">Category Name</label>
                    <input id="cat-name" name="name" required maxlength="120" placeholder="e.g. Laboratory Facilities" />
                </div>
                <div class="field">
                    <label for="cat-desc">Description</label>
                    <textarea id="cat-desc" name="description" style="min-height: 80px" placeholder="Briefly describe what complaints fall into this category"></textarea>
                </div>
                <div class="field">
                    <label for="cat-role">Responsible Authority</label>
                    <select id="cat-role" name="assigned_role" required>
                        @foreach (['cse_admin'=>'CSE Department Head', 'hall_admin'=>'Hall Provost', 'library_admin'=>'Chief Librarian', 'proctor'=>'Proctor'] as $role=>$label)
                            <option value="{{ $role }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <label class="small" style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer">
                    <input type="checkbox" name="is_active" value="1" checked /> Active category
                </label>
                <div style="margin-top: 16px">
                    <button class="btn" type="submit">Add Category</button>
                </div>
            </form>
        </div>

        <div class="card">
            <h2>Routing Guide</h2>
            <p class="muted" style="line-height: 1.6">
                <strong>CSE / Academic:</strong> Assigned to CSE Department Head.<br />
                <strong>Hall / Hostel:</strong> Assigned to Hall Provost.<br />
                <strong>Library:</strong> Assigned to Chief Librarian.<br />
                <strong>Campus / Proctor:</strong> Assigned to University Proctor.
            </p>
            <p class="small" style="margin-top: 14px">
                Note: Updating a category routing affects newly submitted complaints. Existing complaints maintain their recorded assignments.
            </p>
        </div>
    </div>

    <div class="card" style="margin-top: 24px">
        <h2>Configured Categories</h2>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Assigned Authority</th>
                        <th>Status</th>
                        <th>Update Routing</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <strong>{{ $category->name }}</strong><br />
                                <span class="small">{{ $category->description }}</span>
                            </td>
                            <td>
                                <span class="badge badge-role">
                                    {{ ['cse_admin'=>'CSE Department Head','hall_admin'=>'Hall Provost','library_admin'=>'Chief Librarian','proctor'=>'Proctor'][$category->assigned_role] ?? $category->assigned_role }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $category->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('superadmin.categories.update', $category) }}" style="display: flex; gap: 8px; align-items: center">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="name" value="{{ $category->name }}" />
                                    <input type="hidden" name="description" value="{{ $category->description }}" />
                                    <select name="assigned_role" aria-label="Assigned role" style="width: auto; min-width: 140px; padding: 6px 10px; font-size: 12px">
                                        @foreach (['cse_admin'=>'CSE Head','hall_admin'=>'Hall Provost','library_admin'=>'Chief Librarian','proctor'=>'Proctor'] as $role=>$label)
                                            <option value="{{ $role }}" @selected($category->assigned_role === $role)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="is_active" value="{{ $category->is_active ? 1 : 0 }}" />
                                    <button class="btn smallbtn secondary" type="submit">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
