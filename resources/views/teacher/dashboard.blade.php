@extends('layouts.app')
@section('title', 'Teacher Dashboard')
@section('page-title', 'Teacher Dashboard')

@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>Dashboard
    </a>
    <a href="{{ route('teacher.questions.index') }}"><i class="bi bi-question-circle"></i>Question Bank</a>
    <a href="{{ route('teacher.quizzes.index') }}"><i class="bi bi-journal-check"></i>Quizzes</a>
    <a href="{{ route('teacher.assignments.index') }}"><i class="bi bi-file-earmark-text"></i>Assignments</a>
    <a href="{{ route('teacher.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')

{{-- Welcome banner --}}
<div class="welcome-banner mb-4">
    <div class="wb-content">
        <div class="wb-icon"><i class="bi bi-person-video3"></i></div>
        <div>
            <div class="wb-title">Welcome, {{ explode(' ', auth()->user()->name)[0] }}! 👋</div>
            <div class="wb-sub">Manage your quizzes, assignments and track student progress.</div>
        </div>
    </div>
    <div class="wb-date"><i class="bi bi-calendar3"></i>{{ now()->format('l, d M Y') }}</div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-4">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#e0f2fe;color:#0284c7;">
                <i class="bi bi-book-fill"></i>
            </div>
            <h2 style="color:#0284c7;">{{ $teacher->subjects->count() }}</h2>
            <p>Assigned Subjects</p>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#ede9fe;color:#7c3aed;">
                <i class="bi bi-journal-check"></i>
            </div>
            <h2 style="color:#7c3aed;">{{ $teacher->quizzes->count() }}</h2>
            <p>Total Quizzes</p>
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#fef9c3;color:#ca8a04;">
                <i class="bi bi-file-earmark-text-fill"></i>
            </div>
            <h2 style="color:#ca8a04;">{{ $teacher->assignments->count() }}</h2>
            <p>Total Assignments</p>
        </div>
    </div>
</div>

{{-- Quick links --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('teacher.quizzes.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>New Quiz
            </a>
            <a href="{{ route('teacher.assignments.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle me-1"></i>New Assignment
            </a>
            <a href="{{ route('teacher.questions.create') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Add Question
            </a>
        </div>
    </div>
</div>

{{-- Activity --}}
<div class="row g-4">
    <div class="col-12 col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#e0f2fe;color:#0284c7;"><i class="bi bi-book-fill"></i></span>
                <strong>My Subjects</strong>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($teacher->subjects as $subject)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-medium">{{ $subject->name }}</span>
                        <span class="badge" style="background:#e0f2fe;color:#0284c7;font-size:0.72rem;">
                            {{ $subject->class->name ?? '' }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No subjects assigned yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#ede9fe;color:#7c3aed;"><i class="bi bi-journal-check"></i></span>
                <strong>Recent Quizzes</strong>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($recent_quizzes as $quiz)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-medium">{{ $quiz->title }}</span>
                        <span class="badge {{ $quiz->isExpired() ? 'bg-danger' : 'bg-success' }}" style="font-size:0.7rem;">
                            {{ $quiz->deadline->format('d M') }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No quizzes yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#fef9c3;color:#a16207;"><i class="bi bi-file-earmark-text-fill"></i></span>
                <strong>Recent Assignments</strong>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($recent_assignments as $a)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-medium">{{ $a->title }}</span>
                        <span class="badge {{ $a->isExpired() ? 'bg-danger' : 'bg-success' }}" style="font-size:0.7rem;">
                            {{ $a->deadline->format('d M') }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No assignments yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<style>
.welcome-banner {
    background: linear-gradient(135deg, #0c4a6e 0%, #0369a1 50%, #0284c7 100%);
    border-radius: 16px;
    padding: 22px 26px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    box-shadow: 0 4px 20px rgba(3,105,161,0.3);
}
.wb-content { display: flex; align-items: center; gap: 16px; }
.wb-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,0.15);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: #bae6fd;
    flex-shrink: 0;
}
.wb-title { font-size: 1.05rem; font-weight: 700; color: #fff; margin-bottom: 3px; }
.wb-sub   { font-size: 0.81rem; color: rgba(255,255,255,0.5); }
.wb-date  { font-size: 0.79rem; color: rgba(255,255,255,0.45); white-space: nowrap; }
.card-hdr-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.88rem;
    flex-shrink: 0;
}
</style>
@endsection
