@extends('layouts.app')
@section('title', 'Students')
@section('page-title', 'Students Management')
@section('sidebar')
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('admin.classes.index') }}"><i class="bi bi-building"></i>Classes</a>
    <a href="{{ route('admin.subjects.index') }}"><i class="bi bi-book"></i>Subjects</a>
    <a href="{{ route('admin.students.index') }}" class="active"><i class="bi bi-people"></i>Students</a>
    <a href="{{ route('admin.teachers.index') }}"><i class="bi bi-person-badge"></i>Teachers</a>
    <a href="{{ route('admin.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')
<div class="page-hdr mb-4">
    <div>
        <div class="page-hdr-title">All Students</div>
        <div class="page-hdr-sub">Manage registered students, their details and account status.</div>
    </div>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1"></i>Register Student
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th class="d-none d-sm-table-cell">Admission No.</th>
                    <th class="d-none d-lg-table-cell">Father's Name</th>
                    <th class="d-none d-sm-table-cell">Class</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td class="text-muted" style="font-size:0.8rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="av-circle" style="background:{{ ['#6366f1','#10b981','#f59e0b','#ef4444','#3b82f6','#8b5cf6'][$loop->index % 6] }};">
                                @if($student->picture)
                                    <img src="{{ asset('storage/'.$student->picture) }}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                                @else
                                    {{ strtoupper(substr($student->user->name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div class="fw-semibold" style="font-size:0.9rem;">{{ $student->user->name }}</div>
                                <div class="d-sm-none text-muted" style="font-size:0.76rem;">{{ $student->admission_number }} &bull; {{ $student->class->name ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-sm-table-cell"><code style="font-size:0.8rem;">{{ $student->admission_number }}</code></td>
                    <td class="d-none d-lg-table-cell" style="color:#64748b;font-size:0.87rem;">{{ $student->father_name ?? '—' }}</td>
                    <td class="d-none d-sm-table-cell">
                        <span class="class-pill">{{ $student->class->name ?? '—' }}</span>
                    </td>
                    <td>
                        @if($student->user->is_blocked)
                            <span class="status-pill danger"><i class="bi bi-slash-circle me-1"></i>Blocked</span>
                        @else
                            <span class="status-pill success"><i class="bi bi-check-circle me-1"></i>Active</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('admin.students.show', $student) }}"
                               class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="View Profile">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.students.edit', $student) }}"
                               class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit Student">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.students.block', $student) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm {{ $student->user->is_blocked ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                        data-bs-toggle="tooltip"
                                        title="{{ $student->user->is_blocked ? 'Unblock Account' : 'Block Account' }}">
                                    <i class="bi bi-{{ $student->user->is_blocked ? 'unlock' : 'lock' }}"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <div>No students registered yet.</div>
                            <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-sm mt-2">Register First Student</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.page-hdr { display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
.page-hdr-title { font-size:1.15rem; font-weight:700; color:#0f172a; }
.page-hdr-sub   { font-size:0.8rem; color:#64748b; margin-top:2px; }
.av-circle {
    width:34px; height:34px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-size:0.78rem; font-weight:700; color:#fff;
    flex-shrink:0; overflow:hidden;
}
.class-pill {
    display:inline-block; padding:3px 10px;
    background:#ede9fe; color:#6d28d9;
    border-radius:99px; font-size:0.75rem; font-weight:600;
}
.status-pill {
    display:inline-flex; align-items:center;
    padding:3px 10px; border-radius:6px;
    font-size:0.74rem; font-weight:600;
}
.status-pill.success { background:#dcfce7; color:#16a34a; }
.status-pill.danger  { background:#fee2e2; color:#dc2626; }
.empty-state { color:#94a3b8; }
.empty-state i { font-size:2.5rem; display:block; margin-bottom:8px; }
</style>
@endsection
