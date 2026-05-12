@extends('layouts.app')
@section('title', 'Student Reports')
@section('page-title', 'Student Reports')
@section('sidebar')
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('admin.classes.index') }}"><i class="bi bi-building"></i>Classes</a>
    <a href="{{ route('admin.subjects.index') }}"><i class="bi bi-book"></i>Subjects</a>
    <a href="{{ route('admin.students.index') }}"><i class="bi bi-people"></i>Students</a>
    <a href="{{ route('admin.teachers.index') }}"><i class="bi bi-person-badge"></i>Teachers</a>
    <a href="{{ route('admin.reports') }}" class="active"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')

{{-- Filter Card --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="card-hdr-icon" style="background:#ede9fe;color:#7c3aed;"><i class="bi bi-funnel-fill"></i></span>
            <strong style="font-size:0.9rem;">Filter Report</strong>
        </div>
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-12 col-sm-6 col-md-4">
                <label class="form-label">Class</label>
                <select name="class_id" class="form-select" onchange="this.form.submit()">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <label class="form-label">Student</label>
                <select name="student_id" class="form-select" onchange="this.form.submit()">
                    <option value="">— Select Student —</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" {{ $studentId == $s->id ? 'selected' : '' }}>{{ $s->user->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

@if($report)
@php
    $attempts   = $report->quizAttempts;
    $avgQ       = $attempts->count() > 0 ? round($attempts->avg(fn($a) => $a->total_marks > 0 ? ($a->score/$a->total_marks)*100 : 0), 1) : null;
    $subs       = $report->assignmentSubmissions;
    $gradedSubs = $subs->whereNotNull('grade');
    $avgA       = $gradedSubs->count() > 0 ? round($gradedSubs->avg('grade'), 1) : null;
@endphp
<div class="row g-4">
    {{-- Student Card --}}
    <div class="col-12 col-md-3">
        <div class="card overflow-hidden">
            <div style="height:4px;background:linear-gradient(90deg,#6366f1,#a78bfa,#38bdf8);"></div>
            <div class="card-body text-center p-4">
                <div class="profile-avatar mx-auto mb-3">
                    {{ strtoupper(substr($report->user->name, 0, 2)) }}
                </div>
                <h6 class="fw-700 mb-1">{{ $report->user->name }}</h6>
                <div class="text-muted small mb-1">{{ $report->admission_number }}</div>
                <div class="class-pill mt-1">{{ $report->class->name ?? '—' }}</div>
            </div>
            <div class="d-flex border-top">
                <div class="mini-stat">
                    <div class="mini-num" style="color:#6366f1;">{{ $attempts->count() }}</div>
                    <div class="mini-label">Quizzes</div>
                </div>
                <div class="mini-stat border-start">
                    <div class="mini-num" style="color:#10b981;">{{ $avgQ !== null ? $avgQ.'%' : '—' }}</div>
                    <div class="mini-label">Avg</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-9">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#ede9fe;color:#7c3aed;"><i class="bi bi-journal-check"></i></span>
                <strong>Quiz Results</strong>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr><th>Quiz</th><th class="d-none d-md-table-cell">Subject</th><th>Score</th><th>%</th><th>Grade</th></tr>
                    </thead>
                    <tbody>
                        @forelse($attempts as $a)
                        @php
                            $pct = $a->total_marks > 0 ? round(($a->score/$a->total_marks)*100,1) : 0;
                            $grade = $pct>=80?'A':($pct>=65?'B':($pct>=50?'C':($pct>=40?'D':'F')));
                            $gc  = $pct>=80?'#16a34a':($pct>=65?'#2563eb':($pct>=50?'#ca8a04':($pct>=40?'#64748b':'#dc2626')));
                            $gbg = $pct>=80?'#dcfce7':($pct>=65?'#dbeafe':($pct>=50?'#fef9c3':($pct>=40?'#f1f5f9':'#fee2e2')));
                        @endphp
                        <tr>
                            <td class="fw-medium">{{ $a->quiz->title ?? '—' }}</td>
                            <td class="d-none d-md-table-cell text-muted" style="font-size:0.85rem;">{{ $a->quiz->subject->name ?? '—' }}</td>
                            <td>{{ $a->score }}/{{ $a->total_marks }}</td>
                            <td>
                                <div class="score-bar-wrap">
                                    <div class="score-bar" style="width:{{ $pct }}%;background:{{ $gc }};"></div>
                                </div>
                                <span style="font-size:0.8rem;color:#64748b;">{{ $pct }}%</span>
                            </td>
                            <td><span class="grade-pill" style="background:{{ $gbg }};color:{{ $gc }};">{{ $grade }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">No quiz attempts yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-file-earmark-text-fill"></i></span>
                <strong>Assignment Results</strong>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr><th>Assignment</th><th class="d-none d-md-table-cell">Subject</th><th>Grade</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($subs as $sub)
                        <tr>
                            <td class="fw-medium">{{ $sub->assignment->title ?? '—' }}</td>
                            <td class="d-none d-md-table-cell text-muted" style="font-size:0.85rem;">{{ $sub->assignment->subject->name ?? '—' }}</td>
                            <td class="fw-semibold">{{ $sub->grade ?? '—' }}</td>
                            <td>
                                @if($sub->is_zero_marked) <span class="status-pill danger">Late/Zero</span>
                                @elseif($sub->is_late)    <span class="status-pill warning">Late</span>
                                @else                     <span class="status-pill success">On Time</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">No submissions yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@else
<div class="empty-prompt">
    <i class="bi bi-graph-up-arrow"></i>
    <div class="fw-600 mt-2">Select a student above to view their report</div>
    <div class="text-muted small mt-1">Filter by class first, then choose a student.</div>
</div>
@endif

<style>
.fw-700 { font-weight:700!important; }
.fw-600 { font-weight:600!important; }
.card-hdr-icon { width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0; }
.profile-avatar { width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#a78bfa);display:flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:800;color:#fff; }
.class-pill { display:inline-block;padding:3px 10px;background:#ede9fe;color:#6d28d9;border-radius:99px;font-size:0.75rem;font-weight:600; }
.mini-stat { flex:1;text-align:center;padding:10px 6px; }
.mini-num  { font-size:1rem;font-weight:800;line-height:1; }
.mini-label{ font-size:0.67rem;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-top:2px; }
.status-pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:0.74rem;font-weight:600; }
.status-pill.success { background:#dcfce7;color:#16a34a; }
.status-pill.danger  { background:#fee2e2;color:#dc2626; }
.status-pill.warning { background:#fef9c3;color:#a16207; }
.score-bar-wrap { height:5px;background:#f1f5f9;border-radius:99px;width:70px;display:inline-block;vertical-align:middle;margin-right:6px; }
.score-bar { height:100%;border-radius:99px;max-width:100%; }
.grade-pill { display:inline-block;padding:2px 10px;border-radius:99px;font-size:0.74rem;font-weight:700; }
.empty-prompt { text-align:center;padding:60px 24px;color:#94a3b8; }
.empty-prompt i { font-size:3rem;display:block;margin-bottom:8px; }
</style>
@endsection
