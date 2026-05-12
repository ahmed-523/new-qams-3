@extends('layouts.app')
@section('title', 'Classes')
@section('page-title', 'Classes Management')
@section('sidebar')
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('admin.classes.index') }}" class="active"><i class="bi bi-building"></i>Classes</a>
    <a href="{{ route('admin.subjects.index') }}"><i class="bi bi-book"></i>Subjects</a>
    <a href="{{ route('admin.students.index') }}"><i class="bi bi-people"></i>Students</a>
    <a href="{{ route('admin.teachers.index') }}"><i class="bi bi-person-badge"></i>Teachers</a>
    <a href="{{ route('admin.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')
<div class="page-hdr mb-4">
    <div>
        <div class="page-hdr-title">All Classes</div>
        <div class="page-hdr-sub">Create and manage academic classes and their enrollments.</div>
    </div>
    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Add Class
    </a>
</div>

<div class="row g-3">
    @forelse($classes as $class)
    <div class="col-12 col-sm-6 col-lg-4">
        <div class="class-card">
            <div class="cc-top">
                <div class="cc-icon">
                    <i class="bi bi-building-fill"></i>
                </div>
                <div class="cc-actions">
                    <a href="{{ route('admin.classes.edit', $class) }}"
                       class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('admin.classes.destroy', $class) }}" method="POST"
                          class="d-inline" onsubmit="return confirm('Delete this class?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="cc-name">{{ $class->name }}</div>
            @if($class->description)
                <div class="cc-desc">{{ $class->description }}</div>
            @endif
            <div class="cc-stats">
                <div class="cc-stat">
                    <span class="cc-stat-num" style="color:#6366f1;">{{ $class->subjects_count }}</span>
                    <span class="cc-stat-label">Subjects</span>
                </div>
                <div class="cc-divider"></div>
                <div class="cc-stat">
                    <span class="cc-stat-num" style="color:#10b981;">{{ $class->students_count }}</span>
                    <span class="cc-stat-label">Students</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card text-center py-5">
            <div style="color:#cbd5e1;">
                <i class="bi bi-building" style="font-size:2.5rem;display:block;margin-bottom:8px;"></i>
                No classes added yet.
                <div class="mt-2">
                    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary btn-sm">Add First Class</a>
                </div>
            </div>
        </div>
    </div>
    @endforelse
</div>

<style>
.page-hdr { display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap; }
.page-hdr-title { font-size:1.15rem;font-weight:700;color:#0f172a; }
.page-hdr-sub   { font-size:0.8rem;color:#64748b;margin-top:2px; }
.class-card {
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:14px;
    padding:20px;
    height:100%;
    transition:box-shadow 0.2s,transform 0.2s;
}
.class-card:hover { box-shadow:0 8px 28px rgba(0,0,0,0.08);transform:translateY(-2px); }
.cc-top { display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px; }
.cc-icon {
    width:44px;height:44px;border-radius:12px;
    background:linear-gradient(135deg,#6366f1,#a78bfa);
    display:flex;align-items:center;justify-content:center;
    font-size:1.2rem;color:#fff;
}
.cc-actions { display:flex;gap:5px; }
.cc-name { font-size:1.05rem;font-weight:700;color:#0f172a;margin-bottom:4px; }
.cc-desc { font-size:0.8rem;color:#94a3b8;margin-bottom:12px;line-height:1.4; }
.cc-stats { display:flex;align-items:center;gap:16px;margin-top:14px;padding-top:12px;border-top:1px solid #f1f5f9; }
.cc-stat { display:flex;align-items:center;gap:6px; }
.cc-stat-num { font-size:1.1rem;font-weight:800;line-height:1; }
.cc-stat-label { font-size:0.74rem;color:#94a3b8;font-weight:500; }
.cc-divider { width:1px;height:20px;background:#e2e8f0; }
</style>
@endsection
