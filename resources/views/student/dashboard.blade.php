@extends('layouts.app')
@section('title', 'My Dashboard')
@section('page-title', 'My Dashboard')

@section('sidebar')
    <a href="{{ route('student.dashboard') }}" class="active"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('student.quizzes.index') }}"><i class="bi bi-journal-check"></i>My Quizzes</a>
    <a href="{{ route('student.assignments.index') }}"><i class="bi bi-file-earmark-text"></i>My Assignments</a>
    <a href="{{ route('student.results') }}"><i class="bi bi-graph-up"></i>My Results</a>
@endsection

@section('content')

@php
    $pendingQuizzesCount = $all_quizzes
        ->filter(fn($quiz) => $quiz->deadline > now() && ! $attempted_quiz_ids->contains($quiz->id))
        ->count();
    $pendingAssignmentsCount = $upcoming_assignments
        ->filter(fn($a) => ! $submitted_assignment_ids->contains($a->id))
        ->count();
@endphp

{{-- Welcome banner --}}
<div class="welcome-banner mb-4">
    <div class="wb-content">
        <div class="wb-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <div>
            <div class="wb-title">Hello, {{ explode(' ', auth()->user()->name)[0] }}! 👋</div>
            <div class="wb-sub">
                Class: <strong style="color:#bbf7d0;">{{ $student->class->name ?? 'Not Assigned' }}</strong>
                &nbsp;— Keep up the great work!
            </div>
        </div>
    </div>
    <div class="wb-date"><i class="bi bi-calendar3"></i>{{ now()->format('l, d M Y') }}</div>
</div>

{{-- Stat cards --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-4">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#fef3c7;color:#d97706;">
                <i class="bi bi-journal-check"></i>
            </div>
            <h2 style="color:#d97706;">{{ $pendingQuizzesCount }}</h2>
            <p>Pending Quizzes</p>
            @if($pendingQuizzesCount > 0)
                <a href="{{ route('student.quizzes.index') }}" class="stat-action">
                    Attempt now <i class="bi bi-arrow-right"></i>
                </a>
            @endif
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#fee2e2;color:#dc2626;">
                <i class="bi bi-file-earmark-text-fill"></i>
            </div>
            <h2 style="color:#dc2626;">{{ $pendingAssignmentsCount }}</h2>
            <p>Pending Assignments</p>
            @if($pendingAssignmentsCount > 0)
                <a href="{{ route('student.assignments.index') }}" class="stat-action">
                    Submit now <i class="bi bi-arrow-right"></i>
                </a>
            @endif
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#dcfce7;color:#16a34a;">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <h2 style="color:#16a34a;font-size:1.4rem;">{{ $student->class->name ?? 'N/A' }}</h2>
            <p>My Class</p>
        </div>
    </div>
</div>

{{-- Activity --}}
<div class="row g-4">
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="card-hdr-icon" style="background:#fef3c7;color:#d97706;"><i class="bi bi-journal-check"></i></span>
                    <strong>All Quizzes</strong>
                </div>
                <a href="{{ route('student.quizzes.index') }}" class="btn btn-outline-primary btn-sm" style="font-size:0.76rem;">View All</a>
            </div>
            <div style="max-height:380px;overflow-y:auto;">
                <ul class="list-group list-group-flush">
                    @forelse($all_quizzes as $quiz)
                        <li class="list-group-item d-flex justify-content-between align-items-center gap-2 flex-wrap py-3">
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-truncate" style="font-size:0.88rem;">{{ $quiz->title }}</div>
                                <div style="font-size:0.75rem;color:#64748b;">{{ $quiz->subject->name ?? '' }}</div>
                            </div>
                            <div class="text-end flex-shrink-0">
                                <div style="font-size:0.72rem;color:#dc2626;margin-bottom:4px;">
                                    <i class="bi bi-clock me-1"></i>{{ $quiz->deadline->format('d M') }}
                                </div>
                                @if($attempted_quiz_ids->contains($quiz->id))
                                    <span class="badge bg-success" style="font-size:0.7rem;">Done</span>
                                @elseif($quiz->deadline < now())
                                    <span class="badge bg-secondary" style="font-size:0.7rem;">Expired</span>
                                @else
                                    <a href="{{ route('student.quizzes.attempt', $quiz) }}"
                                       class="btn btn-sm btn-primary py-1 px-2" style="font-size:0.76rem;">
                                        Attempt
                                    </a>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No quizzes available.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="card-hdr-icon" style="background:#fee2e2;color:#dc2626;"><i class="bi bi-file-earmark-text-fill"></i></span>
                    <strong>Upcoming Assignments</strong>
                </div>
                <a href="{{ route('student.assignments.index') }}" class="btn btn-outline-primary btn-sm" style="font-size:0.76rem;">View All</a>
            </div>
            <div style="max-height:380px;overflow-y:auto;">
                <ul class="list-group list-group-flush">
                    @forelse($upcoming_assignments as $assignment)
                        <li class="list-group-item d-flex justify-content-between align-items-center gap-2 flex-wrap py-3">
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-semibold text-truncate" style="font-size:0.88rem;">{{ $assignment->title }}</div>
                                <div style="font-size:0.75rem;color:#64748b;">{{ $assignment->subject->name ?? '' }}</div>
                            </div>
                            <div class="text-end flex-shrink-0">
                                <div style="font-size:0.72rem;color:#dc2626;margin-bottom:4px;">
                                    <i class="bi bi-clock me-1"></i>{{ $assignment->deadline->format('d M') }}
                                </div>
                                @if($submitted_assignment_ids->contains($assignment->id))
                                    <span class="badge bg-success" style="font-size:0.7rem;">Submitted</span>
                                @else
                                    <a href="{{ route('student.assignments.show', $assignment) }}"
                                       class="btn btn-sm btn-warning py-1 px-2" style="font-size:0.76rem;">
                                        Submit
                                    </a>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No upcoming assignments.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-banner {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%);
    border-radius: 16px;
    padding: 22px 26px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    box-shadow: 0 4px 20px rgba(4,120,87,0.3);
}
.wb-content { display: flex; align-items: center; gap: 16px; }
.wb-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,0.15);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: #a7f3d0;
    flex-shrink: 0;
}
.wb-title { font-size: 1.05rem; font-weight: 700; color: #fff; margin-bottom: 3px; }
.wb-sub   { font-size: 0.81rem; color: rgba(255,255,255,0.55); }
.wb-date  { font-size: 0.79rem; color: rgba(255,255,255,0.4); white-space: nowrap; }
.stat-action {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.75rem;
    color: #6366f1;
    text-decoration: none;
    font-weight: 600;
    margin-top: 6px;
    transition: gap 0.2s;
}
.stat-action:hover { gap: 8px; }
.card-hdr-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.88rem;
    flex-shrink: 0;
}
.min-w-0 { min-width: 0; }
</style>
@endsection
