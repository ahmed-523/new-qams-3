@extends('layouts.app')
@section('title', 'Student Profile')
@section('page-title', 'Student Profile')
@section('sidebar')
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('admin.classes.index') }}"><i class="bi bi-building"></i>Classes</a>
    <a href="{{ route('admin.subjects.index') }}"><i class="bi bi-book"></i>Subjects</a>
    <a href="{{ route('admin.students.index') }}" class="active"><i class="bi bi-people"></i>Students</a>
    <a href="{{ route('admin.teachers.index') }}"><i class="bi bi-person-badge"></i>Teachers</a>
    <a href="{{ route('admin.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')

@php
    $attempts   = $student->quizAttempts;
    $avgQ       = $attempts->count() > 0 ? round($attempts->avg(fn($a) => $a->total_marks > 0 ? ($a->score/$a->total_marks)*100 : 0), 1) : null;
    $subs       = $student->assignmentSubmissions;
    $gradedSubs = $subs->whereNotNull('grade');
    $avgA       = $gradedSubs->count() > 0 ? round($gradedSubs->avg('grade'), 1) : null;
@endphp

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to Students
    </a>
    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-warning">
        <i class="bi bi-pencil me-1"></i>Edit Student
    </a>
</div>

<div class="row g-4">
    {{-- Profile Card --}}
    <div class="col-12 col-md-4 col-lg-3">
        <div class="card overflow-hidden">
            <div style="height:5px;background:linear-gradient(90deg,#6366f1,#a78bfa,#38bdf8);"></div>
            <div class="card-body text-center p-4">
                <div class="profile-avatar mx-auto mb-3">
                    @if($student->picture)
                        <img src="{{ asset('storage/'.$student->picture) }}" alt="Profile">
                    @else
                        {{ strtoupper(substr($student->user->name, 0, 2)) }}
                    @endif
                </div>
                <h5 class="fw-700 mb-1">{{ $student->user->name }}</h5>
                <div class="mb-2"><code style="font-size:0.82rem;color:#64748b;">{{ $student->user->username }}</code></div>
                @if($student->user->is_blocked)
                    <span class="status-pill danger"><i class="bi bi-slash-circle me-1"></i>Blocked</span>
                @else
                    <span class="status-pill success"><i class="bi bi-check-circle me-1"></i>Active</span>
                @endif

                <div class="info-list mt-3">
                    <div class="info-row">
                        <span class="info-label"><i class="bi bi-card-text"></i>Admission No</span>
                        <span class="info-val fw-600">{{ $student->admission_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="bi bi-person"></i>Father's Name</span>
                        <span class="info-val">{{ $student->father_name ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="bi bi-building"></i>Class</span>
                        <span class="info-val fw-600" style="color:#6366f1;">{{ $student->class->name ?? '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- Mini stats --}}
            <div class="d-flex border-top">
                <div class="mini-stat">
                    <div class="mini-num" style="color:#6366f1;">{{ $attempts->count() }}</div>
                    <div class="mini-label">Quizzes</div>
                </div>
                <div class="mini-stat border-start">
                    <div class="mini-num" style="color:#10b981;">{{ $avgQ !== null ? $avgQ.'%' : '—' }}</div>
                    <div class="mini-label">Avg Score</div>
                </div>
                <div class="mini-stat border-start">
                    <div class="mini-num" style="color:#f59e0b;">{{ $subs->count() }}</div>
                    <div class="mini-label">Submissions</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Results --}}
    <div class="col-12 col-md-8 col-lg-9">
        {{-- Quiz Results --}}
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#ede9fe;color:#7c3aed;"><i class="bi bi-journal-check"></i></span>
                <strong>Quiz Results</strong>
                <span class="badge ms-auto" style="background:#ede9fe;color:#6d28d9;">{{ $attempts->count() }}</span>
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
                            <td class="d-none d-md-table-cell text-muted">{{ $a->quiz->subject->name ?? '—' }}</td>
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
                        <tr><td colspan="5" class="text-center text-muted py-4">No quiz attempts yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Assignment Results --}}
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-file-earmark-text-fill"></i></span>
                <strong>Assignment Submissions</strong>
                <span class="badge ms-auto" style="background:#fef9c3;color:#a16207;">{{ $subs->count() }}</span>
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
                            <td class="d-none d-md-table-cell text-muted">{{ $sub->assignment->subject->name ?? '—' }}</td>
                            <td class="fw-semibold">{{ $sub->grade ?? '—' }}</td>
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
.fw-700 { font-weight:700!important; }
.fw-600 { font-weight:600!important; }
.profile-avatar {
    width:80px; height:80px; border-radius:50%;
    background:linear-gradient(135deg,#6366f1,#a78bfa);
    display:flex; align-items:center; justify-content:center;
    font-size:1.4rem; font-weight:800; color:#fff;
    overflow:hidden;
}
.profile-avatar img { width:100%; height:100%; object-fit:cover; }
.status-pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:0.74rem;font-weight:600; }
.status-pill.success { background:#dcfce7;color:#16a34a; }
.status-pill.danger  { background:#fee2e2;color:#dc2626; }
.status-pill.warning { background:#fef9c3;color:#a16207; }
.info-list { text-align:left; }
.info-row { display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid #f1f5f9;gap:8px; }
.info-row:last-child { border-bottom:none; }
.info-label { font-size:0.76rem;color:#94a3b8;display:flex;align-items:center;gap:5px; }
.info-val { font-size:0.84rem;color:#0f172a;text-align:right; }
.mini-stat { flex:1;text-align:center;padding:12px 8px; }
.mini-num  { font-size:1.1rem;font-weight:800;line-height:1; }
.mini-label{ font-size:0.68rem;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-top:2px; }
.card-hdr-icon { width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;flex-shrink:0; }
.score-bar-wrap { height:5px;background:#f1f5f9;border-radius:99px;width:80px;display:inline-block;vertical-align:middle;margin-right:6px; }
.score-bar { height:100%;border-radius:99px;max-width:100%; }
.grade-pill { display:inline-block;padding:2px 10px;border-radius:99px;font-size:0.74rem;font-weight:700; }
</style>
@endsection
