@extends('layouts.app')
@section('title', 'My Quizzes')
@section('page-title', 'My Quizzes')
@section('sidebar')
    <a href="{{ route('student.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('student.quizzes.index') }}" class="active"><i class="bi bi-journal-check"></i>My Quizzes</a>
    <a href="{{ route('student.assignments.index') }}"><i class="bi bi-file-earmark-text"></i>My Assignments</a>
    <a href="{{ route('student.results') }}"><i class="bi bi-graph-up"></i>My Results</a>
@endsection

@section('content')

@php
    $pendingCount   = $quizzes->filter(fn($q) => !$attempted->contains($q->id) && !$q->isExpired())->count();
    $completedCount = $attempted->count();
    $expiredCount   = $quizzes->filter(fn($q) => !$attempted->contains($q->id) && $q->isExpired())->count();
@endphp

{{-- Summary pills --}}
<div class="d-flex gap-3 mb-4 flex-wrap">
    <div class="summary-pill" style="background:#fef9c3;color:#a16207;border:1px solid #fde68a;">
        <i class="bi bi-clock me-2"></i><strong>{{ $pendingCount }}</strong> Pending
    </div>
    <div class="summary-pill" style="background:#dcfce7;color:#16a34a;border:1px solid #bbf7d0;">
        <i class="bi bi-check-circle me-2"></i><strong>{{ $completedCount }}</strong> Completed
    </div>
    @if($expiredCount > 0)
    <div class="summary-pill" style="background:#fee2e2;color:#dc2626;border:1px solid #fecaca;">
        <i class="bi bi-x-circle me-2"></i><strong>{{ $expiredCount }}</strong> Missed
    </div>
    @endif
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Quiz</th>
                    <th class="d-none d-md-table-cell">Subject</th>
                    <th class="d-none d-sm-table-cell">Marks</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quizzes as $quiz)
                @php $isAttempted = $attempted->contains($quiz->id); $isExpired = $quiz->isExpired(); @endphp
                <tr>
                    <td class="text-muted" style="font-size:0.8rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-semibold" style="font-size:0.9rem;">{{ $quiz->title }}</div>
                        <div class="d-md-none text-muted" style="font-size:0.76rem;">{{ $quiz->subject->name ?? '—' }}</div>
                    </td>
                    <td class="d-none d-md-table-cell" style="font-size:0.86rem;color:#64748b;">{{ $quiz->subject->name ?? '—' }}</td>
                    <td class="d-none d-sm-table-cell">
                        <span class="fw-600" style="color:#6366f1;">{{ $quiz->total_marks }}</span>
                        <span class="text-muted small">pts</span>
                    </td>
                    <td>
                        <div class="deadline-cell {{ $isExpired && !$isAttempted ? 'expired' : ($isExpired ? '' : 'active') }}">
                            <i class="bi bi-clock me-1"></i>{{ $quiz->deadline->format('d M Y') }}
                        </div>
                    </td>
                    <td>
                        @if($isAttempted)
                            <span class="status-pill success"><i class="bi bi-check-circle me-1"></i>Done</span>
                        @elseif($isExpired)
                            <span class="status-pill danger"><i class="bi bi-x-circle me-1"></i>Missed</span>
                        @else
                            <span class="status-pill warning"><i class="bi bi-clock me-1"></i>Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($isAttempted)
                            @if($quiz->is_result_published)
                                <a href="{{ route('student.quizzes.result', $quiz) }}"
                                   class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="View Result">
                                    <i class="bi bi-eye me-1"></i><span class="d-none d-sm-inline">Result</span>
                                </a>
                            @else
                                <span class="awaiting-badge" data-bs-toggle="tooltip" title="Teacher hasn't published results yet">
                                    <i class="bi bi-hourglass-split me-1"></i><span class="d-none d-sm-inline">Awaiting</span>
                                </span>
                            @endif
                        @elseif(!$isExpired)
                            <a href="{{ route('student.quizzes.attempt', $quiz) }}"
                               class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Attempt Quiz Now">
                                <i class="bi bi-pencil-square me-1"></i><span class="d-none d-sm-inline">Attempt</span>
                            </a>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div style="color:#cbd5e1;">
                            <i class="bi bi-journal-check" style="font-size:2.5rem;display:block;margin-bottom:8px;"></i>
                            No quizzes assigned to your class yet.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.fw-600 { font-weight:600!important; }
.summary-pill { display:inline-flex;align-items:center;padding:6px 14px;border-radius:99px;font-size:0.82rem;font-weight:500; }
.deadline-cell { font-size:0.82rem;font-weight:600;display:inline-flex;align-items:center;white-space:nowrap; }
.deadline-cell.expired { color:#dc2626; }
.deadline-cell.active  { color:#16a34a; }
.status-pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:0.74rem;font-weight:600; }
.status-pill.success { background:#dcfce7;color:#16a34a; }
.status-pill.danger  { background:#fee2e2;color:#dc2626; }
.status-pill.warning { background:#fef9c3;color:#a16207; }
.awaiting-badge { display:inline-flex;align-items:center;padding:4px 10px;border-radius:6px;background:#f1f5f9;color:#64748b;font-size:0.78rem;font-weight:500; }
</style>
@endsection
