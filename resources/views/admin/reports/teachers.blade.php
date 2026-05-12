@extends('layouts.app')
@section('title', 'Teacher Reports')
@section('page-title', 'Teacher Activity Reports')
@section('sidebar')
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('admin.classes.index') }}"><i class="bi bi-building"></i>Classes</a>
    <a href="{{ route('admin.subjects.index') }}"><i class="bi bi-book"></i>Subjects</a>
    <a href="{{ route('admin.students.index') }}"><i class="bi bi-people"></i>Students</a>
    <a href="{{ route('admin.teachers.index') }}"><i class="bi bi-person-badge"></i>Teachers</a>
    <a href="{{ route('admin.reports') }}" class="active"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <div class="page-hdr-title">Teacher Activity</div>
        <div class="page-hdr-sub">Overview of quiz creation, assignments, and subject assignments per teacher.</div>
    </div>
    <a href="{{ route('admin.reports') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>All Reports
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Teacher</th>
                    <th class="d-none d-sm-table-cell">Subjects</th>
                    <th>Quizzes</th>
                    <th>Assignments</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                @php
                    $quizCount  = $teacher->quizzes->count();
                    $assCount   = $teacher->assignments->count();
                    $subjCount  = $teacher->subjects->count();
                @endphp
                <tr>
                    <td class="text-muted" style="font-size:0.8rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="av-circle" style="background:{{ ['#6366f1','#0284c7','#10b981','#f59e0b'][$loop->index % 4] }};">
                                {{ strtoupper(substr($teacher->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold" style="font-size:0.9rem;">{{ $teacher->user->name }}</div>
                                <div style="font-size:0.75rem;color:#94a3b8;"><code>{{ $teacher->user->username }}</code></div>
                            </div>
                        </div>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="act-pill blue">{{ $subjCount }} subject{{ $subjCount !== 1 ? 's' : '' }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="act-bar-wrap">
                                <div class="act-bar" style="width:{{ min($quizCount * 10, 100) }}%;background:#6366f1;"></div>
                            </div>
                            <span class="act-num" style="color:#6366f1;">{{ $quizCount }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="act-bar-wrap">
                                <div class="act-bar" style="width:{{ min($assCount * 10, 100) }}%;background:#f59e0b;"></div>
                            </div>
                            <span class="act-num" style="color:#f59e0b;">{{ $assCount }}</span>
                        </div>
                    </td>
                    <td>
                        @if($teacher->user->is_blocked)
                            <span class="status-pill danger">Blocked</span>
                        @else
                            <span class="status-pill success">Active</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">No teachers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.page-hdr-title { font-size:1.1rem;font-weight:700;color:#0f172a; }
.page-hdr-sub   { font-size:0.8rem;color:#64748b;margin-top:2px; }
.av-circle { width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:#fff;flex-shrink:0; }
.act-pill { display:inline-block;padding:3px 10px;border-radius:99px;font-size:0.74rem;font-weight:600; }
.act-pill.blue { background:#dbeafe;color:#1d4ed8; }
.act-bar-wrap { width:60px;height:5px;background:#f1f5f9;border-radius:99px;flex-shrink:0; }
.act-bar { height:100%;border-radius:99px;max-width:100%; }
.act-num { font-size:0.85rem;font-weight:700;min-width:20px; }
.status-pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:0.74rem;font-weight:600; }
.status-pill.success { background:#dcfce7;color:#16a34a; }
.status-pill.danger  { background:#fee2e2;color:#dc2626; }
</style>
@endsection
