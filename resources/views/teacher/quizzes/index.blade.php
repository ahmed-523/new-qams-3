@extends('layouts.app')
@section('title', 'My Quizzes')
@section('page-title', 'My Quizzes')
@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('teacher.questions.index') }}"><i class="bi bi-question-circle"></i>Question Bank</a>
    <a href="{{ route('teacher.quizzes.index') }}" class="active"><i class="bi bi-journal-check"></i>Quizzes</a>
    <a href="{{ route('teacher.assignments.index') }}"><i class="bi bi-file-earmark-text"></i>Assignments</a>
    <a href="{{ route('teacher.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')
<div class="page-hdr mb-4">
    <div>
        <div class="page-hdr-title">My Quizzes</div>
        <div class="page-hdr-sub">Create, manage and publish quiz results for your students.</div>
    </div>
    <a href="{{ route('teacher.quizzes.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Create Quiz
    </a>
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
                    <th>Attempts</th>
                    <th class="d-none d-sm-table-cell">Results</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quizzes as $quiz)
                @php $expired = $quiz->isExpired(); @endphp
                <tr>
                    <td class="text-muted" style="font-size:0.8rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-semibold" style="font-size:0.9rem;">{{ $quiz->title }}</div>
                        <div class="d-md-none text-muted" style="font-size:0.76rem;">{{ $quiz->subject->name ?? '—' }}</div>
                    </td>
                    <td class="d-none d-md-table-cell" style="font-size:0.87rem;color:#64748b;">{{ $quiz->subject->name ?? '—' }}</td>
                    <td class="d-none d-sm-table-cell">
                        <span class="fw-600" style="color:#6366f1;">{{ $quiz->total_marks }}</span>
                        <span class="text-muted small">pts</span>
                    </td>
                    <td>
                        <div class="deadline-cell {{ $expired ? 'expired' : 'active' }}">
                            <i class="bi bi-{{ $expired ? 'clock-history' : 'clock' }} me-1"></i>
                            {{ $quiz->deadline->format('d M Y') }}
                        </div>
                    </td>
                    <td>
                        <span class="attempts-badge">{{ $quiz->attempts->count() }}</span>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        @if($quiz->is_result_published)
                            <span class="result-pill published"><i class="bi bi-check-circle me-1"></i>Published</span>
                        @else
                            <span class="result-pill hidden"><i class="bi bi-eye-slash me-1"></i>Hidden</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('teacher.quizzes.show', $quiz) }}"
                               class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('teacher.quizzes.results', $quiz) }}"
                               class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Results">
                                <i class="bi bi-list-check"></i>
                            </a>
                            <a href="{{ route('teacher.quizzes.edit', $quiz) }}"
                               class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit / Extend Deadline">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if(!$quiz->is_result_published)
                            <form action="{{ route('teacher.quizzes.publish', $quiz) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-success"
                                        data-bs-toggle="tooltip" title="Publish Results"
                                        onclick="return confirm('Publish results? Students will see their scores.')">
                                    <i class="bi bi-send"></i>
                                </button>
                            </form>
                            @else
                                <span class="btn btn-sm btn-success disabled" data-bs-toggle="tooltip" title="Already Published">
                                    <i class="bi bi-check-lg"></i>
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div style="color:#cbd5e1;">
                            <i class="bi bi-journal-check" style="font-size:2.5rem;display:block;margin-bottom:8px;"></i>
                            No quizzes yet.
                            <div class="mt-2"><a href="{{ route('teacher.quizzes.create') }}" class="btn btn-primary btn-sm">Create First Quiz</a></div>
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
.attempts-badge { display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;background:#dbeafe;color:#1d4ed8;border-radius:50%;font-size:0.8rem;font-weight:700; }
.result-pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:6px;font-size:0.74rem;font-weight:600; }
.result-pill.published { background:#dcfce7;color:#16a34a; }
.result-pill.hidden    { background:#f1f5f9;color:#64748b; }
</style>
@endsection
