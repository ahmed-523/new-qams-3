@extends('layouts.app')
@section('title', 'Subjects')
@section('page-title', 'Subjects Management')
@section('sidebar')
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('admin.classes.index') }}"><i class="bi bi-building"></i>Classes</a>
    <a href="{{ route('admin.subjects.index') }}" class="active"><i class="bi bi-book"></i>Subjects</a>
    <a href="{{ route('admin.students.index') }}"><i class="bi bi-people"></i>Students</a>
    <a href="{{ route('admin.teachers.index') }}"><i class="bi bi-person-badge"></i>Teachers</a>
    <a href="{{ route('admin.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')
<div class="page-hdr mb-4">
    <div>
        <div class="page-hdr-title">All Subjects</div>
        <div class="page-hdr-sub">Manage subjects and link them to classes and teachers.</div>
    </div>
    <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Add Subject
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $subject)
                @php
                    $colors = ['#6366f1','#0284c7','#10b981','#f59e0b','#ec4899','#8b5cf6'];
                    $col = $colors[$loop->index % count($colors)];
                @endphp
                <tr>
                    <td class="text-muted" style="font-size:0.8rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="subj-icon" style="background:{{ $col }}18;color:{{ $col }};">
                                <i class="bi bi-book-fill"></i>
                            </div>
                            <span class="fw-semibold" style="font-size:0.9rem;">{{ $subject->name }}</span>
                        </div>
                    </td>
                    <td>
                        @if($subject->class)
                            <span class="class-pill" style="background:{{ $col }}15;color:{{ $col }};">
                                {{ $subject->class->name }}
                            </span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.subjects.edit', $subject) }}"
                               class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit Subject">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST"
                                  class="d-inline" onsubmit="return confirm('Delete this subject?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete Subject">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5">
                        <div style="color:#cbd5e1;">
                            <i class="bi bi-book" style="font-size:2.5rem;display:block;margin-bottom:8px;"></i>
                            No subjects added yet.
                            <div class="mt-2"><a href="{{ route('admin.subjects.create') }}" class="btn btn-primary btn-sm">Add First Subject</a></div>
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
.subj-icon { width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0; }
.class-pill { display:inline-block;padding:3px 10px;border-radius:99px;font-size:0.74rem;font-weight:600; }
</style>
@endsection
