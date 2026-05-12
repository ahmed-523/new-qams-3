@extends('layouts.app')
@section('title', 'Assign Subjects')
@section('page-title', 'Assign Subjects')
@section('sidebar')
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('admin.classes.index') }}"><i class="bi bi-building"></i>Classes</a>
    <a href="{{ route('admin.subjects.index') }}"><i class="bi bi-book"></i>Subjects</a>
    <a href="{{ route('admin.students.index') }}"><i class="bi bi-people"></i>Students</a>
    <a href="{{ route('admin.teachers.index') }}" class="active"><i class="bi bi-person-badge"></i>Teachers</a>
    <a href="{{ route('admin.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')

{{-- Teacher info banner --}}
<div class="teacher-banner mb-4">
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <div class="t-avatar">{{ strtoupper(substr($teacher->user->name, 0, 2)) }}</div>
        <div>
            <div style="font-size:1.1rem;font-weight:700;color:#fff;">{{ $teacher->user->name }}</div>
            <div style="font-size:0.8rem;color:rgba(255,255,255,0.55);">
                <code style="color:rgba(255,255,255,0.7);">{{ $teacher->user->username }}</code>
                @if($teacher->education)
                    &nbsp;&bull;&nbsp;<i class="bi bi-mortarboard me-1"></i>{{ $teacher->education }}
                @endif
            </div>
        </div>
        <div class="ms-auto d-flex gap-2 align-items-center">
            @if($teacher->user->is_blocked)
                <span class="status-pill danger">Blocked</span>
            @else
                <span class="status-pill success">Active</span>
            @endif
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-light">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Assigned Subjects --}}
    <div class="col-12 col-md-7">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-check-circle-fill"></i></span>
                <strong>Currently Assigned Subjects</strong>
                <span class="badge ms-auto" style="background:#dcfce7;color:#166534;">{{ $teacher->subjects->count() }}</span>
            </div>
            <div class="card-body p-3">
                @forelse($teacher->subjects as $subject)
                <div class="subj-row">
                    <div class="d-flex align-items-center gap-2">
                        <div class="subj-icon"><i class="bi bi-book-fill"></i></div>
                        <div>
                            <div class="fw-semibold" style="font-size:0.9rem;">{{ $subject->name }}</div>
                            <div style="font-size:0.76rem;color:#94a3b8;">{{ $subject->class->name ?? 'No class' }}</div>
                        </div>
                    </div>
                    <form action="{{ route('admin.teachers.remove-subject', [$teacher, $subject]) }}" method="POST"
                          onsubmit="return confirm('Remove {{ $subject->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </form>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-book" style="font-size:2rem;color:#cbd5e1;"></i>
                    <p class="mt-2 mb-0 text-muted" style="font-size:0.85rem;">No subjects assigned yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Assign New --}}
    <div class="col-12 col-md-5">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#dbeafe;color:#2563eb;"><i class="bi bi-plus-circle-fill"></i></span>
                <strong>Assign a Subject</strong>
            </div>
            <div class="card-body">
                @if($allSubjects->isEmpty())
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        No subjects exist yet.
                        <a href="{{ route('admin.subjects.create') }}">Create subjects first</a>.
                    </div>
                @else
                    <form action="{{ route('admin.teachers.assign-subject', $teacher) }}" method="POST">
                        @csrf
                        <label class="form-label">Select Subject to Assign</label>
                        @php
                            $grouped = $allSubjects->groupBy(fn($s) => $s->class->name ?? 'No Class');
                            $alreadyAssigned = $teacher->subjects->pluck('id')->toArray();
                        @endphp
                        <select name="subject_id" class="form-select mb-3" required>
                            <option value="">— Choose a subject —</option>
                            @foreach($grouped as $className => $subjects)
                                <optgroup label="{{ $className }}">
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ in_array($subject->id, $alreadyAssigned) ? 'disabled' : '' }}>
                                            {{ $subject->name }}
                                            {{ in_array($subject->id, $alreadyAssigned) ? '(assigned)' : '' }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg me-1"></i>Assign Subject
                        </button>
                    </form>
                    <p class="text-muted small mt-3 mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Already-assigned subjects are disabled. <a href="{{ route('admin.subjects.create') }}">Add more subjects</a>.
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.teacher-banner {
    background:linear-gradient(135deg,#0f172a,#1e293b,#1e3a5f);
    border-radius:16px; padding:20px 24px;
    box-shadow:0 4px 20px rgba(0,0,0,0.2);
}
.t-avatar {
    width:52px;height:52px;border-radius:14px;
    background:linear-gradient(135deg,#6366f1,#a78bfa);
    display:flex;align-items:center;justify-content:center;
    font-size:1.1rem;font-weight:800;color:#fff;
    flex-shrink:0;
}
.status-pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:0.74rem;font-weight:600; }
.status-pill.success { background:#dcfce7;color:#16a34a; }
.status-pill.danger  { background:#fee2e2;color:#dc2626; }
.card-hdr-icon { width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0; }
.subj-row {
    display:flex;align-items:center;justify-content:space-between;gap:10px;
    padding:10px 12px;border-radius:10px;background:#f8fafc;
    border:1px solid #e2e8f0;margin-bottom:8px;
}
.subj-row:last-child { margin-bottom:0; }
.subj-icon { width:30px;height:30px;background:#e0f2fe;color:#0284c7;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0; }
</style>
@endsection
