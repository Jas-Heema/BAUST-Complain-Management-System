@extends('layouts.app')
@section('title', 'Administrator Accounts | BAUST')
@section('content')
    <div class="section-head">
        <div>
            <p class="small" style="font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase">System Configuration</p>
            <h1>Administrator Accounts</h1>
            <p class="muted">Create and manage accounts for university administrative authorities.</p>
        </div>
    </div>

    <div class="two grid">
        <div class="card">
            <h2>Create Administrator</h2>
            <form method="POST" action="{{ route('superadmin.administrators.store') }}">
                @csrf
                <div class="field">
                    <label for="admin-name">Full Name</label>
                    <input id="admin-name" name="name" required maxlength="120" placeholder="e.g. Dr. Md. Rafiqul Islam" />
                </div>
                <div class="field">
                    <label for="admin-email">Official University Email</label>
                    <input id="admin-email" type="email" name="email" required placeholder="e.g. csehead@baust.edu.bd" />
                </div>
                <div class="field">
                    <label for="admin-role">Administrative Role</label>
                    <select id="admin-role" name="role" required>
                        @foreach (['cse_admin'=>'CSE Department Head','hall_admin'=>'Hall Provost','library_admin'=>'Chief Librarian','proctor'=>'Proctor','super_admin'=>'Super Administrator'] as $role=>$label)
                            <option value="{{ $role }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="admin-pass">Password</label>
                    <input id="admin-pass" type="password" name="password" minlength="8" required />
                </div>
                <div class="field">
                    <label for="admin-pass-confirm">Confirm Password</label>
                    <input id="admin-pass-confirm" type="password" name="password_confirmation" minlength="8" required />
                </div>
                <button class="btn" type="submit">Create Account</button>
            </form>
        </div>

        <div class="card">
            <h2>Role Permissions</h2>
            <p class="muted" style="line-height: 1.6">
                <strong>CSE Head:</strong> Reviews academic and CSE laboratory/facilities complaints.<br />
                <strong>Hall Provost:</strong> Manages complaints related to university halls and student hostels.<br />
                <strong>Chief Librarian:</strong> Manages library book, facility, and account complaints.<br />
                <strong>University Proctor:</strong> Investigates conduct, transport, and campus-wide matters.<br />
                <strong>Super Admin:</strong> Full administrative rights over system configuration and user accounts.
            </p>
        </div>
    </div>

    <div class="card" style="margin-top: 24px">
        <h2>Existing Administrators</h2>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Assigned Role</th>
                        <th>Account Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($administrators as $admin)
                        <tr>
                            <td><strong>{{ $admin->name }}</strong></td>
                            <td>{{ $admin->email }}</td>
                            <td><span class="badge badge-role">{{ $admin->roleLabel() }}</span></td>
                            <td>
                                <span class="badge {{ $admin->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $admin->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                @if ($admin->id !== auth()->id())
                                    <form method="POST" action="{{ route('superadmin.administrators.toggle', $admin) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="btn smallbtn {{ $admin->is_active ? 'danger' : 'secondary' }}"
                                            type="submit"
                                        >
                                            {{ $admin->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="small" style="font-weight: 700">Current Session</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
