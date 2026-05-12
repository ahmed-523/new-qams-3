@extends('layouts.app')
@section('title', 'Submissions')
@section('page-title', 'Assignment Submissions')
@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('teacher.questions.index') }}"><i class="bi bi-question-circle"></i>Question Bank</a>
    <a href="{{ route('teacher.quizzes.index') }}"><i class="bi bi-journal-check"></i>Quizzes</a>
    <a href="{{ route('teacher.assignments.index') }}" class="active"><i class="bi bi-file-earmark-text"></i>Assignments</a>
    <a href="{{ route('teacher.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')

{{-- Assignment info banner --}}
<div class="assign-banner mb-4">
    <div>
        <div style="font-size:0.7rem;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Assignment Submissions</div>
        <h5 class="mb-2" style="color:#fff;font-weight:700;">{{ $assignment->title }}</h5>
        <div style="display:flex;flex-wrap:wrap;gap:14px;font-size:0.82rem;color:rgba(255,255,255,0.6);">
            <span><i class="bi bi-book me-1"></i>{{ $assignment->subject->name ?? '—' }}</span>
            <span><i class="bi bi-star me-1"></i>{{ $assignment->total_marks }} marks</span>
            <span class="{{ $assignment->isExpired() ? '' : 'text-success' }}">
                <i class="bi bi-clock me-1"></i>{{ $assignment->deadline->format('d M Y, h:i A') }}
                @if($assignment->isExpired())
                    <span style="color:#fca5a5;"> — Expired</span>
                @endif
            </span>
        </div>
    </div>
    <div class="ab-stat">
        <div class="ab-num">{{ $submissions->count() }}</div>
        <div class="ab-label">Total Submissions</div>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th class="d-none d-md-table-cell">Answer / File</th>
                    <th>Status</th>
                    <th>Grade</th>
                    <th class="d-none d-lg-table-cell">Feedback</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $sub)
                <tr>
                    <td class="text-muted" style="font-size:0.8rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="av-circle">{{ strtoupper(substr($sub->student->user->name ?? '?', 0, 1)) }}</div>
                            <span class="fw-semibold" style="font-size:0.9rem;">{{ $sub->student->user->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td class="d-none d-md-table-cell" style="font-size:0.85rem;max-width:200px;">
                        @if($sub->solution_text)
                            <span class="text-muted text-truncate d-block">{{ Str::limit($sub->solution_text, 45) }}</span>
                        @elseif($sub->file_path)
                            <a href="{{ route('download.submission', $sub) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-download me-1"></i>Download File
                            </a>
                        @else
                            <em class="text-muted small">No submission</em>
                        @endif
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
                    <td>
                        @if($sub->grade !== null)
                            <span class="fw-700" style="color:#6366f1;">{{ $sub->grade }}</span>
                            <span class="text-muted" style="font-size:0.8rem;">/{{ $assignment->total_marks }}</span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="d-none d-lg-table-cell text-muted" style="font-size:0.83rem;">
                        {{ $sub->feedback ? Str::limit($sub->feedback, 35) : '—' }}
                    </td>
                    <td>
                        @if(!$sub->is_zero_marked)
                        <a href="{{ route('teacher.assignments.grade.form', [$assignment, $sub]) }}"
                           class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Grade this submission">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        @else
                        <span class="text-muted small">Auto-zero</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-5">No submissions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.fw-700 { font-weight:700!important; }
.assign-banner {
    background:linear-gradient(135deg,#064e3b,#065f46,#0f766e);
    border-radius:16px; padding:22px 26px;
    display:flex; align-items:center; justify-content:space-between;
    gap:16px; flex-wrap:wrap;
    box-shadow:0 4px 20px rgba(4,120,87,0.3);
}
.ab-stat { text-align:center;min-width:80px; }
.ab-num  { font-size:2rem;font-weight:800;color:#fff;line-height:1; }
.ab-label{ font-size:0.68rem;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.8px; }
.av-circle { width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#a78bfa);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:#fff;flex-shrink:0; }
.status-pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:0.74rem;font-weight:600; }
.status-pill.success { background:#dcfce7;color:#16a34a; }
.status-pill.danger  { background:#fee2e2;color:#dc2626; }
.status-pill.warning { background:#fef9c3;color:#a16207; }
</style>
@endsection
