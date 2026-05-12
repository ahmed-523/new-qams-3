@extends('layouts.app')
@section('title', 'Teachers')
@section('page-title', 'Teachers Management')
@section('sidebar')
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('admin.classes.index') }}"><i class="bi bi-building"></i>Classes</a>
    <a href="{{ route('admin.subjects.index') }}"><i class="bi bi-book"></i>Subjects</a>
    <a href="{{ route('admin.students.index') }}"><i class="bi bi-people"></i>Students</a>
    <a href="{{ route('admin.teachers.index') }}" class="active"><i class="bi bi-person-badge"></i>Teachers</a>
    <a href="{{ route('admin.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')
<div class="page-hdr mb-4">
    <div>
        <div class="page-hdr-title">All Teachers</div>
        <div class="page-hdr-sub">Manage teachers, assign subjects and control account access.</div>
    </div>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-person-plus me-1"></i>Register Teacher
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Teacher</th>
                    <th class="d-none d-lg-table-cell">Education</th>
                    <th class="d-none d-sm-table-cell">Subjects</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                <tr>
                    <td class="text-muted" style="font-size:0.8rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="av-circle" style="background:{{ ['#6366f1','#0284c7','#10b981','#f59e0b','#8b5cf6','#ec4899'][$loop->index % 6] }};">
                                {{ strtoupper(substr($teacher->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold" style="font-size:0.9rem;">{{ $teacher->user->name }}</div>
                                <div style="font-size:0.76rem;color:#94a3b8;"><code>{{ $teacher->user->username }}</code></div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-lg-table-cell" style="font-size:0.86rem;color:#64748b;">{{ $teacher->education ?? '—' }}</td>
                    <td class="d-none d-sm-table-cell">
                        @forelse($teacher->subjects->take(3) as $s)
                            <span class="subj-tag">{{ $s->name }}</span>
                        @empty
                            <span style="font-size:0.8rem;color:#ef4444;"><i class="bi bi-exclamation-circle me-1"></i>None</span>
                        @endforelse
                        @if($teacher->subjects->count() > 3)
                            <span style="font-size:0.76rem;color:#94a3b8;">+{{ $teacher->subjects->count()-3 }}</span>
                        @endif
                    </td>
                    <td>
                        @if($teacher->user->is_blocked)
                            <span class="status-pill danger"><i class="bi bi-slash-circle me-1"></i>Blocked</span>
                        @else
                            <span class="status-pill success"><i class="bi bi-check-circle me-1"></i>Active</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('admin.teachers.show', $teacher) }}"
                               class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Assign Subjects">
                                <i class="bi bi-book"></i>
                            </a>
                            <a href="{{ route('admin.teachers.edit', $teacher) }}"
                               class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit Teacher">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.teachers.block', $teacher) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm {{ $teacher->user->is_blocked ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                        data-bs-toggle="tooltip"
                                        title="{{ $teacher->user->is_blocked ? 'Unblock Account' : 'Block Account' }}">
                                    <i class="bi bi-{{ $teacher->user->is_blocked ? 'unlock' : 'lock' }}"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="empty-state">
                            <i class="bi bi-person-badge"></i>
                            <div>No teachers registered yet.</div>
                            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary btn-sm mt-2">Register First Teacher</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.page-hdr { display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap; }
.page-hdr-title { font-size:1.15rem;font-weight:700;color:#0f172a; }
.page-hdr-sub   { font-size:0.8rem;color:#64748b;margin-top:2px; }
.av-circle { width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.78rem;font-weight:700;color:#fff;flex-shrink:0; }
.subj-tag { display:inline-block;padding:2px 8px;background:#e0f2fe;color:#0284c7;border-radius:5px;font-size:0.73rem;font-weight:600;margin:1px; }
.status-pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:0.74rem;font-weight:600; }
.status-pill.success { background:#dcfce7;color:#16a34a; }
.status-pill.danger  { background:#fee2e2;color:#dc2626; }
.empty-state { color:#94a3b8; }
.empty-state i { font-size:2.5rem;display:block;margin-bottom:8px; }
</style>
@endsection
