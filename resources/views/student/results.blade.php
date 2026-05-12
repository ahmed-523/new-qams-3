@extends('layouts.app')
@section('title', 'My Results')
@section('page-title', 'My Results & Performance')

@section('sidebar')
    <a href="{{ route('student.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('student.quizzes.index') }}"><i class="bi bi-journal-check"></i>My Quizzes</a>
    <a href="{{ route('student.assignments.index') }}"><i class="bi bi-file-earmark-text"></i>My Assignments</a>
    <a href="{{ route('student.results') }}" class="active"><i class="bi bi-graph-up"></i>My Results</a>
@endsection

@section('content')

@php
    $totalAttemptedCount = $quizAttempts->count();
    $publishedForAvg = $quizAttempts->filter(fn($a) => $a->quiz && $a->quiz->is_result_published);
    $avgQuiz = $publishedForAvg->count() > 0
        ? round($publishedForAvg->avg(fn($a) => $a->total_marks > 0 ? ($a->score/$a->total_marks)*100 : 0), 1)
        : 0;
    $gradedSubs = collect($submissions)->whereNotNull('grade');
    $avgGrade   = $gradedSubs->count() > 0 ? round($gradedSubs->avg('grade'), 1) : '-';
@endphp

{{-- Performance banner --}}
<div class="perf-banner mb-4">
    <div class="perf-item">
        <div class="perf-num">{{ $totalAttemptedCount }}</div>
        <div class="perf-label">Quizzes Attempted</div>
    </div>
    <div class="perf-divider"></div>
    <div class="perf-item">
        <div class="perf-num">{{ $avgQuiz }}%</div>
        <div class="perf-label">Avg Quiz Score</div>
    </div>
    <div class="perf-divider"></div>
    <div class="perf-item">
        <div class="perf-num">{{ $avgAssignment }}</div>
        <div class="perf-label">Avg Assignment Grade</div>
    </div>
</div>

<div class="row g-4">
    {{-- Quiz Results --}}
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#ede9fe;color:#7c3aed;"><i class="bi bi-journal-check"></i></span>
                <strong>Quiz Results</strong>
                <span class="badge ms-auto" style="background:#ede9fe;color:#7c3aed;">{{ $quizAttempts->count() }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Quiz</th>
                            <th class="d-none d-md-table-cell">Subject</th>
                            <th>Score</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quizAttempts as $a)
                            @php
                                $isPublished = $a->quiz && $a->quiz->is_result_published;
                                $pct = $a->total_marks > 0 ? round(($a->score / $a->total_marks) * 100, 1) : 0;
                                $grade = $pct>=80?'A':($pct>=65?'B':($pct>=50?'C':($pct>=40?'D':'F')));
                                $gc    = $pct>=80?'#16a34a':($pct>=65?'#2563eb':($pct>=50?'#ca8a04':($pct>=40?'#64748b':'#dc2626')));
                                $gbg   = $pct>=80?'#dcfce7':($pct>=65?'#dbeafe':($pct>=50?'#fef9c3':($pct>=40?'#f1f5f9':'#fee2e2')));
                            @endphp
                            <tr>
                                <td class="fw-medium" style="font-size:0.87rem;">{{ $a->quiz->title ?? '-' }}</td>
                                <td class="d-none d-md-table-cell" style="color:#64748b;font-size:0.84rem;">{{ $a->quiz->subject->name ?? '-' }}</td>
                                @if($isPublished)
                                    <td style="font-size:0.87rem;">{{ $a->score }}/{{ $a->total_marks }}</td>
                                    <td>
                                        <span class="grade-pill" style="background:{{ $gbg }};color:{{ $gc }};">
                                            {{ $grade }} &bull; {{ $pct }}%
                                        </span>
                                    </td>
                                @else
                                    <td colspan="2">
                                        <span class="badge" style="background:#f1f5f9;color:#64748b;font-size:0.72rem;">
                                            <i class="bi bi-hourglass-split me-1"></i>Awaiting Result
                                        </span>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No quiz attempts yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Assignment Grades --}}
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-file-earmark-text-fill"></i></span>
                <strong>Assignment Grades</strong>
                <span class="badge ms-auto" style="background:#fef9c3;color:#a16207;">{{ count($submissions) }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Assignment</th>
                            <th class="d-none d-md-table-cell">Subject</th>
                            <th>Grade</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $sub)
                            <tr>
                                <td class="fw-medium" style="font-size:0.87rem;">{{ $sub->assignment->title ?? '-' }}</td>
                                <td class="d-none d-md-table-cell" style="color:#64748b;font-size:0.84rem;">{{ $sub->assignment->subject->name ?? '-' }}</td>
                                <td class="fw-semibold" style="font-size:0.87rem;">
                                    {{ $sub->grade ?? '—' }}
                                </td>
                                <td>
                                    @if($sub->is_zero_marked)
                                        <span class="status-pill danger">Late/Zero</span>
                                    @elseif($sub->is_late)
                                        <span class="status-pill warning">Late</span>
                                    @else
                                        <span class="status-pill success">On Time</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No submissions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.perf-banner {
    background: linear-gradient(135deg, #1e1b4b, #312e81, #3730a3);
    border-radius: 16px;
    padding: 24px 32px;
    display: flex;
    align-items: center;
    justify-content: space-around;
    gap: 20px;
    flex-wrap: wrap;
    box-shadow: 0 4px 24px rgba(99,102,241,0.3);
}
.perf-item { text-align: center; }
.perf-num  { font-size: 2rem; font-weight: 800; color: #fff; letter-spacing: -1px; line-height: 1; }
.perf-label{ font-size: 0.75rem; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 0.8px; margin-top: 4px; font-weight: 500; }
.perf-divider {
    width: 1px; height: 48px;
    background: rgba(255,255,255,0.12);
}
@media (max-width: 480px) {
    .perf-divider { display: none; }
    .perf-banner  { gap: 12px; }
    .perf-num     { font-size: 1.6rem; }
}
.card-hdr-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.88rem;
    flex-shrink: 0;
}
.grade-pill {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 99px;
    font-size: 0.74rem;
    font-weight: 700;
}
.status-pill {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 0.72rem;
    font-weight: 600;
}
.status-pill.success { background:#dcfce7; color:#16a34a; }
.status-pill.warning { background:#fef9c3; color:#a16207; }
.status-pill.danger  { background:#fee2e2; color:#dc2626; }
</style>
@endsection
