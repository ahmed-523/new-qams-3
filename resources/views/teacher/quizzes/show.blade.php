@extends('layouts.app')
@section('title', 'Quiz Details')
@section('page-title', 'Quiz Details')
@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('teacher.questions.index') }}"><i class="bi bi-question-circle"></i>Question Bank</a>
    <a href="{{ route('teacher.quizzes.index') }}" class="active"><i class="bi bi-journal-check"></i>Quizzes</a>
    <a href="{{ route('teacher.assignments.index') }}"><i class="bi bi-file-earmark-text"></i>Assignments</a>
    <a href="{{ route('teacher.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')

{{-- Header banner --}}
<div class="quiz-detail-banner mb-4">
    <div class="flex-grow-1">
        <div style="font-size:0.7rem;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px;">Quiz Details</div>
        <h5 class="mb-2" style="color:#fff;font-weight:700;">{{ $quiz->title }}</h5>
        <div style="display:flex;flex-wrap:wrap;gap:16px;font-size:0.83rem;color:rgba(255,255,255,0.6);">
            <span><i class="bi bi-book me-1"></i>{{ $quiz->subject->name ?? '—' }}</span>
            <span><i class="bi bi-building me-1"></i>{{ $quiz->class->name ?? '—' }}</span>
            <span><i class="bi bi-star me-1"></i>{{ $quiz->total_marks }} marks</span>
            <span><i class="bi bi-people me-1"></i>{{ $quiz->attempts->count() }} attempts</span>
            <span class="{{ $quiz->isExpired() ? 'text-danger' : '' }}">
                <i class="bi bi-clock me-1"></i>{{ $quiz->deadline->format('d M Y, h:i A') }}
            </span>
        </div>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap mt-2 mt-md-0">
        @if($quiz->is_result_published)
            <span class="result-pill published"><i class="bi bi-check-circle me-1"></i>Published</span>
        @else
            <span class="result-pill hidden"><i class="bi bi-eye-slash me-1"></i>Hidden</span>
        @endif
        <a href="{{ route('teacher.quizzes.results', $quiz) }}" class="btn btn-light btn-sm">
            <i class="bi bi-list-check me-1"></i>Results
        </a>
        <a href="{{ route('teacher.quizzes.edit', $quiz) }}" class="btn btn-outline-light btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
    </div>
</div>

{{-- Questions --}}
<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <span class="card-hdr-icon" style="background:#ede9fe;color:#7c3aed;"><i class="bi bi-question-circle-fill"></i></span>
        <strong>Questions</strong>
        <span class="badge ms-auto" style="background:#ede9fe;color:#6d28d9;">{{ $quiz->questions->count() }}</span>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th class="d-none d-md-table-cell">Type</th>
                    <th class="d-none d-md-table-cell">Answer</th>
                    <th>Marks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quiz->questions as $q)
                <tr>
                    <td class="text-muted" style="font-size:0.8rem;">{{ $loop->iteration }}</td>
                    <td style="font-size:0.88rem;">{{ $q->question_text }}</td>
                    <td class="d-none d-md-table-cell">
                        <span class="type-badge {{ $q->question_type }}">{{ strtoupper($q->question_type) }}</span>
                    </td>
                    <td class="d-none d-md-table-cell"><code style="font-size:0.82rem;color:#16a34a;">{{ $q->correct_answer }}</code></td>
                    <td><span class="fw-600" style="color:#6366f1;">{{ $q->marks }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
.fw-600 { font-weight:600!important; }
.quiz-detail-banner {
    background:linear-gradient(135deg,#1e1b4b,#312e81,#1e3a5f);
    border-radius:16px; padding:22px 26px;
    display:flex; align-items:flex-start; justify-content:space-between;
    gap:16px; flex-wrap:wrap;
    box-shadow:0 4px 20px rgba(99,102,241,0.25);
}
.result-pill { display:inline-flex;align-items:center;padding:5px 12px;border-radius:8px;font-size:0.78rem;font-weight:600; }
.result-pill.published { background:rgba(16,185,129,0.2);color:#6ee7b7; }
.result-pill.hidden    { background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.5); }
.card-hdr-icon { width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0; }
.type-badge { display:inline-block;padding:2px 8px;border-radius:5px;font-size:0.7rem;font-weight:700; }
.type-badge.mcq       { background:#dbeafe;color:#1d4ed8; }
.type-badge.true_false{ background:#dcfce7;color:#16a34a; }
.type-badge.short     { background:#fef9c3;color:#a16207; }
</style>
@endsection
