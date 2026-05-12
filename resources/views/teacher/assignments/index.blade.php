@extends('layouts.app')
@section('title', 'Assignments')
@section('page-title', 'My Assignments')
@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('teacher.questions.index') }}"><i class="bi bi-question-circle"></i>Question Bank</a>
    <a href="{{ route('teacher.quizzes.index') }}"><i class="bi bi-journal-check"></i>Quizzes</a>
    <a href="{{ route('teacher.assignments.index') }}" class="active"><i class="bi bi-file-earmark-text"></i>Assignments</a>
    <a href="{{ route('teacher.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')
<div class="page-hdr mb-4">
    <div>
        <div class="page-hdr-title">My Assignments</div>
        <div class="page-hdr-sub">Upload assignments, track submissions and grade student work.</div>
    </div>
    <a href="{{ route('teacher.assignments.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Create Assignment
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Assignment</th>
                    <th class="d-none d-md-table-cell">Subject</th>
                    <th class="d-none d-sm-table-cell">Marks</th>
                    <th>Deadline</th>
                    <th>Submissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assignments as $a)
                @php $expired = $a->isExpired(); @endphp
                <tr>
                    <td class="text-muted" style="font-size:0.8rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-semibold" style="font-size:0.9rem;">{{ $a->title }}</div>
                        <div class="d-md-none text-muted" style="font-size:0.76rem;">{{ $a->subject->name ?? '—' }}</div>
                    </td>
                    <td class="d-none d-md-table-cell" style="font-size:0.87rem;color:#64748b;">{{ $a->subject->name ?? '—' }}</td>
                    <td class="d-none d-sm-table-cell">
                        <span class="fw-600" style="color:#f59e0b;">{{ $a->total_marks }}</span>
                        <span class="text-muted small">pts</span>
                    </td>
                    <td>
                        <div class="deadline-cell {{ $expired ? 'expired' : 'active' }}">
                            <i class="bi bi-{{ $expired ? 'clock-history' : 'clock' }} me-1"></i>
                            {{ $a->deadline->format('d M Y') }}
                        </div>
                    </td>
                    <td>
                        <span class="attempts-badge" style="background:#fef9c3;color:#a16207;">
                            {{ $a->submissions->count() }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('teacher.assignments.submissions', $a) }}"
                               class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Submissions & Grade">
                                <i class="bi bi-list-check"></i>
                            </a>
                            <a href="{{ route('teacher.assignments.edit', $a) }}"
                               class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit / Extend Deadline">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div style="color:#cbd5e1;">
                            <i class="bi bi-file-earmark-text" style="font-size:2.5rem;display:block;margin-bottom:8px;"></i>
                            No assignments yet.
                            <div class="mt-2"><a href="{{ route('teacher.assignments.create') }}" class="btn btn-primary btn-sm">Create First Assignment</a></div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.page-hdr { display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap; }
.page-hdr-title { font-size:1.15rem;font-weight:700;color:#0f172a; }
.page-hdr-sub   { font-size:0.8rem;color:#64748b;margin-top:2px; }
.fw-600 { font-weight:600!important; }
.deadline-cell { font-size:0.82rem;font-weight:600;display:inline-flex;align-items:center;white-space:nowrap; }
.deadline-cell.expired { color:#dc2626; }
.deadline-cell.active  { color:#16a34a; }
.attempts-badge { display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;font-size:0.8rem;font-weight:700; }
</style>
@endsection
