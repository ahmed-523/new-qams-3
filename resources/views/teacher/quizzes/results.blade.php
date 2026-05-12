@extends('layouts.app')
@section('title', 'Quiz Results')
@section('page-title', 'Quiz Results')
@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('teacher.questions.index') }}"><i class="bi bi-question-circle"></i>Question Bank</a>
    <a href="{{ route('teacher.quizzes.index') }}" class="active"><i class="bi bi-journal-check"></i>Quizzes</a>
    <a href="{{ route('teacher.assignments.index') }}"><i class="bi bi-file-earmark-text"></i>Assignments</a>
    <a href="{{ route('teacher.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')

@php
    $attempts = $quiz->attempts->sortByDesc('score');
    $avgPct   = $attempts->count() > 0 ? round($attempts->avg(fn($a) => $a->total_marks > 0 ? ($a->score/$a->total_marks)*100 : 0), 1) : 0;
    $topScore = $attempts->max('score');
@endphp

{{-- Quiz summary banner --}}
<div class="quiz-banner mb-4">
    <div>
        <div style="font-size:0.72rem;color:rgba(255,255,255,0.45);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Quiz Results</div>
        <div style="font-size:1.1rem;font-weight:700;color:#fff;">{{ $quiz->title }}</div>
        <div style="font-size:0.8rem;color:rgba(255,255,255,0.5);margin-top:2px;">
            {{ $quiz->subject->name ?? '' }} &bull; {{ $quiz->total_marks }} marks total
        </div>
    </div>
    <div class="d-flex align-items-center gap-3 flex-wrap">
        <div class="qb-stat">
            <div class="qb-num">{{ $attempts->count() }}</div>
            <div class="qb-label">Attempts</div>
        </div>
        <div class="qb-stat">
            <div class="qb-num">{{ $avgPct }}%</div>
            <div class="qb-label">Class Avg</div>
        </div>
        <div class="qb-stat">
            <div class="qb-num">{{ $topScore ?? 0 }}</div>
            <div class="qb-label">Top Score</div>
        </div>
        <div>
            @if(!$quiz->is_result_published)
            <form action="{{ route('teacher.quizzes.publish', $quiz) }}" method="POST">
                @csrf
                <button class="btn btn-light btn-sm fw-600"
                        onclick="return confirm('Publish results to students?')">
                    <i class="bi bi-send me-1"></i>Publish Results
                </button>
            </form>
            @else
            <span class="result-pill published"><i class="bi bi-check-circle me-1"></i>Results Published</span>
            @endif
        </div>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Student</th>
                    <th>Score</th>
                    <th>Percentage</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attempts as $attempt)
                @php
                    $pct   = $attempt->total_marks > 0 ? round(($attempt->score/$attempt->total_marks)*100,1) : 0;
                    $grade = $pct>=80?'A':($pct>=65?'B':($pct>=50?'C':($pct>=40?'D':'F')));
                    $gc    = $pct>=80?'#16a34a':($pct>=65?'#2563eb':($pct>=50?'#ca8a04':($pct>=40?'#64748b':'#dc2626')));
                    $gbg   = $pct>=80?'#dcfce7':($pct>=65?'#dbeafe':($pct>=50?'#fef9c3':($pct>=40?'#f1f5f9':'#fee2e2')));
                @endphp
                <tr>
                    <td>
                        @if($loop->iteration <= 3)
                            <span class="rank-badge rank-{{ $loop->iteration }}">{{ $loop->iteration }}</span>
                        @else
                            <span class="text-muted" style="font-size:0.85rem;">{{ $loop->iteration }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="av-circle" style="background:{{ $gc }}20;color:{{ $gc }};">
                                {{ strtoupper(substr($attempt->student->user->name ?? '?', 0, 1)) }}
                            </div>
                            <span class="fw-semibold" style="font-size:0.9rem;">{{ $attempt->student->user->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td class="fw-semibold">{{ $attempt->score }}<span class="text-muted fw-normal">/{{ $attempt->total_marks }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="score-bar-wrap">
                                <div class="score-bar" style="width:{{ $pct }}%;background:{{ $gc }};"></div>
                            </div>
                            <span style="font-size:0.82rem;font-weight:600;color:{{ $gc }};">{{ $pct }}%</span>
                        </div>
                    </td>
                    <td><span class="grade-pill" style="background:{{ $gbg }};color:{{ $gc }};">{{ $grade }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-5">No attempts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.fw-600 { font-weight:600!important; }
.quiz-banner {
    background:linear-gradient(135deg,#1e1b4b,#312e81,#3730a3);
    border-radius:16px; padding:22px 26px;
    display:flex; align-items:center; justify-content:space-between;
    gap:16px; flex-wrap:wrap;
    box-shadow:0 4px 20px rgba(99,102,241,0.3);
}
.qb-stat { text-align:center; }
.qb-num  { font-size:1.4rem;font-weight:800;color:#fff;line-height:1; }
.qb-label{ font-size:0.68rem;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.8px;margin-top:2px; }
.result-pill { display:inline-flex;align-items:center;padding:6px 14px;border-radius:8px;font-size:0.82rem;font-weight:600; }
.result-pill.published { background:#dcfce7;color:#16a34a; }
.av-circle { width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;flex-shrink:0; }
.rank-badge { display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;font-size:0.78rem;font-weight:800; }
.rank-badge.rank-1 { background:#fef9c3;color:#a16207; }
.rank-badge.rank-2 { background:#f1f5f9;color:#475569; }
.rank-badge.rank-3 { background:#fef3c7;color:#92400e; }
.score-bar-wrap { width:80px;height:6px;background:#f1f5f9;border-radius:99px;flex-shrink:0; }
.score-bar { height:100%;border-radius:99px;max-width:100%; }
.grade-pill { display:inline-block;padding:3px 12px;border-radius:99px;font-size:0.78rem;font-weight:700; }
</style>
@endsection
