@extends('layouts.app')
@section('title', 'Question Bank')
@section('page-title', 'Question Bank')
@section('sidebar')
    <a href="{{ route('teacher.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('teacher.questions.index') }}" class="active"><i class="bi bi-question-circle"></i>Question Bank</a>
    <a href="{{ route('teacher.quizzes.index') }}"><i class="bi bi-journal-check"></i>Quizzes</a>
    <a href="{{ route('teacher.assignments.index') }}"><i class="bi bi-file-earmark-text"></i>Assignments</a>
    <a href="{{ route('teacher.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')
<div class="page-hdr mb-4">
    <div>
        <div class="page-hdr-title">Question Bank</div>
        <div class="page-hdr-sub">Create and manage your pool of questions for quizzes.</div>
    </div>
    <a href="{{ route('teacher.questions.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Add Question
    </a>
</div>

<div class="card mb-3" style="border-radius:12px;">
    <div class="card-body py-3">
        <form method="GET" class="d-flex align-items-center gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-2 flex-grow-1" style="max-width:320px;">
                <i class="bi bi-funnel text-muted"></i>
                <select name="subject_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Subjects</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $subjectId == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <span class="text-muted small">{{ $questions->count() }} question{{ $questions->count() !== 1 ? 's' : '' }}</span>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Type</th>
                    <th class="d-none d-md-table-cell">Subject</th>
                    <th>Marks</th>
                    <th class="d-none d-lg-table-cell">Correct Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $q)
                <tr>
                    <td class="text-muted" style="font-size:0.8rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div style="font-size:0.88rem;max-width:300px;">{{ Str::limit($q->question_text, 65) }}</div>
                        <div class="d-md-none text-muted" style="font-size:0.76rem;">{{ $q->subject->name ?? '—' }}</div>
                    </td>
                    <td>
                        @php
                            $types = ['mcq'=>['#dbeafe','#1d4ed8','MCQ'],'true_false'=>['#dcfce7','#16a34a','T/F'],'short'=>['#fef9c3','#a16207','Short']];
                            $t = $types[$q->question_type] ?? ['#f1f5f9','#64748b',strtoupper($q->question_type)];
                        @endphp
                        <span class="type-badge" style="background:{{ $t[0] }};color:{{ $t[1] }};">{{ $t[2] }}</span>
                    </td>
                    <td class="d-none d-md-table-cell" style="font-size:0.86rem;color:#64748b;">{{ $q->subject->name ?? '—' }}</td>
                    <td><span class="fw-700" style="color:#6366f1;">{{ $q->marks }}</span></td>
                    <td class="d-none d-lg-table-cell">
                        <code style="font-size:0.8rem;color:#16a34a;background:#f0fdf4;padding:2px 8px;border-radius:5px;">
                            {{ $q->correct_answer }}
                        </code>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('teacher.questions.edit', $q) }}"
                               class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit Question">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('teacher.questions.destroy', $q) }}" method="POST"
                                  class="d-inline" onsubmit="return confirm('Delete this question?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div style="color:#cbd5e1;">
                            <i class="bi bi-question-circle" style="font-size:2.5rem;display:block;margin-bottom:8px;"></i>
                            No questions yet.
                            <div class="mt-2"><a href="{{ route('teacher.questions.create') }}" class="btn btn-primary btn-sm">Add First Question</a></div>
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
.fw-700 { font-weight:700!important; }
.type-badge { display:inline-block;padding:3px 10px;border-radius:6px;font-size:0.73rem;font-weight:700; }
</style>
@endsection
