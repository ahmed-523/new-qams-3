@extends('layouts.app')
@section('title', 'Reports')
@section('page-title', 'Student Performance Report')
@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('teacher.questions.index') }}"><i class="bi bi-question-circle"></i>Question Bank</a>
    <a href="{{ route('teacher.quizzes.index') }}"><i class="bi bi-journal-check"></i>Quizzes</a>
    <a href="{{ route('teacher.assignments.index') }}"><i class="bi bi-file-earmark-text"></i>Assignments</a>
    <a href="{{ route('teacher.reports') }}" class="active"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')

<div class="mb-4">
    <div style="font-size:1.15rem;font-weight:700;color:#0f172a;">Student Performance</div>
    <div style="font-size:0.82rem;color:#64748b;margin-top:2px;">Quiz scores and assignment grades for students in your subjects.</div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Student</th>
                    <th class="d-none d-md-table-cell">Class</th>
                    <th>Quizzes</th>
                    <th>Quiz Avg</th>
                    <th class="d-none d-sm-table-cell">Assignments</th>
                    <th class="d-none d-sm-table-cell">Assign Avg</th>
                    <th>Overall</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                @php
                    $attempts  = $student->quizAttempts;
                    $avgQuiz   = $attempts->count() > 0 ? round($attempts->avg(fn($a) => $a->total_marks > 0 ? ($a->score/$a->total_marks)*100 : 0), 1) : null;
                    $subs      = $student->assignmentSubmissions->whereNotNull('grade');
                    $avgAssign = $subs->count() > 0 ? round($subs->avg('grade'), 1) : null;
                    $perf      = $avgQuiz !== null ? ($avgQuiz >= 80 ? 'excellent' : ($avgQuiz >= 60 ? 'good' : 'needs')) : 'none';
                @endphp
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="av-circle" style="background:{{ ['#6366f1','#0284c7','#10b981','#f59e0b','#ec4899'][$loop->index % 5] }};">
                                {{ strtoupper(substr($student->user->name, 0, 1)) }}
                            </div>
                            <span class="fw-semibold" style="font-size:0.9rem;">{{ $student->user->name }}</span>
                        </div>
                    </td>
                    <td class="d-none d-md-table-cell">
                        <span class="class-pill">{{ $student->class->name ?? '—' }}</span>
                    </td>
                    <td>
                        <span class="count-badge" style="background:#ede9fe;color:#6d28d9;">{{ $attempts->count() }}</span>
                    </td>
                    <td>
                        @if($avgQuiz !== null)
                        <div class="d-flex align-items-center gap-2">
                            <div class="perf-bar-wrap">
                                <div class="perf-bar" style="width:{{ $avgQuiz }}%;background:{{ $avgQuiz>=80?'#16a34a':($avgQuiz>=60?'#ca8a04':'#dc2626') }};"></div>
                            </div>
                            <span class="fw-600" style="font-size:0.84rem;color:{{ $avgQuiz>=80?'#16a34a':($avgQuiz>=60?'#ca8a04':'#dc2626') }};">{{ $avgQuiz }}%</span>
                        </div>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="count-badge" style="background:#fef9c3;color:#a16207;">{{ $student->assignmentSubmissions->count() }}</span>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        @if($avgAssign !== null)
                            <span class="fw-600" style="font-size:0.87rem;">{{ $avgAssign }}</span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>
                        @if($perf === 'excellent')
                            <span class="perf-pill excellent"><i class="bi bi-star-fill me-1"></i>Excellent</span>
                        @elseif($perf === 'good')
                            <span class="perf-pill good"><i class="bi bi-hand-thumbs-up-fill me-1"></i>Good</span>
                        @elseif($perf === 'needs')
                            <span class="perf-pill needs"><i class="bi bi-exclamation-circle me-1"></i>Needs Attention</span>
                        @else
                            <span class="text-muted small">No data</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-5">No students in your classes yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.fw-600 { font-weight:600!important; }
.av-circle { width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.74rem;font-weight:700;color:#fff;flex-shrink:0; }
.class-pill { display:inline-block;padding:2px 9px;background:#ede9fe;color:#6d28d9;border-radius:99px;font-size:0.73rem;font-weight:600; }
.count-badge { display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;font-size:0.78rem;font-weight:700; }
.perf-bar-wrap { width:60px;height:5px;background:#f1f5f9;border-radius:99px;flex-shrink:0; }
.perf-bar { height:100%;border-radius:99px;max-width:100%; }
.perf-pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:0.73rem;font-weight:600; }
.perf-pill.excellent { background:#dcfce7;color:#16a34a; }
.perf-pill.good      { background:#dbeafe;color:#1d4ed8; }
.perf-pill.needs     { background:#fee2e2;color:#dc2626; }
</style>
@endsection
