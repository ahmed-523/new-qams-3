@extends('layouts.app')
@section('title', 'Change Password')
@section('page-title', 'Change Password')

@section('sidebar')
    @if(auth()->user()->role === 'teacher')
        <a href="{{ route('teacher.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
        <a href="{{ route('teacher.questions.index') }}"><i class="bi bi-question-circle"></i>Question Bank</a>
        <a href="{{ route('teacher.quizzes.index') }}"><i class="bi bi-journal-check"></i>Quizzes</a>
        <a href="{{ route('teacher.assignments.index') }}"><i class="bi bi-file-earmark-text"></i>Assignments</a>
        <a href="{{ route('teacher.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
    @elseif(auth()->user()->role === 'student')
        <a href="{{ route('student.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
        <a href="{{ route('student.quizzes.index') }}"><i class="bi bi-journal-check"></i>My Quizzes</a>
        <a href="{{ route('student.assignments.index') }}"><i class="bi bi-file-earmark-text"></i>My Assignments</a>
        <a href="{{ route('student.results') }}"><i class="bi bi-graph-up"></i>My Results</a>
    @elseif(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
        <a href="{{ route('admin.classes.index') }}"><i class="bi bi-building"></i>Classes</a>
        <a href="{{ route('admin.subjects.index') }}"><i class="bi bi-book"></i>Subjects</a>
        <a href="{{ route('admin.students.index') }}"><i class="bi bi-people"></i>Students</a>
        <a href="{{ route('admin.teachers.index') }}"><i class="bi bi-person-badge"></i>Teachers</a>
        <a href="{{ route('admin.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
    @endif
@endsection

@section('content')
<div class="form-card-wrap-sm">
    <div class="card overflow-hidden">
        {{-- Card top accent --}}
        <div style="height:4px;background:linear-gradient(90deg,#6366f1,#a78bfa);"></div>

        <div class="card-body p-4">
            <div class="text-center mb-4">
                <div class="pwd-icon-wrap">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h5 class="fw-700 mb-1 mt-3">Change Your Password</h5>
                <p class="text-muted small mb-0">Enter your current password and choose a new one.</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="current_password" id="current_password"
                               class="form-control border-start-0 ps-0 @error('current_password') is-invalid @enderror"
                               placeholder="Enter current password" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('current_password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-key text-muted"></i></span>
                        <input type="password" name="new_password" id="new_password"
                               class="form-control border-start-0 ps-0 @error('new_password') is-invalid @enderror"
                               placeholder="Minimum 6 characters" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('new_password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('new_password')
                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirm New Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-key-fill text-muted"></i></span>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                               class="form-control border-start-0 ps-0"
                               placeholder="Repeat new password" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePwd('new_password_confirmation', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-check-lg me-1"></i>Update Password
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-light border w-100">
                    <i class="bi bi-arrow-left me-1"></i>Go Back
                </a>
            </form>
        </div>
    </div>
</div>

<style>
.fw-700 { font-weight: 700 !important; }
.pwd-icon-wrap {
    width: 60px; height: 60px;
    background: linear-gradient(135deg, #ede9fe, #ddd6fe);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto;
    font-size: 1.5rem;
    color: #6d28d9;
}
.input-group-text { border-radius: 8px 0 0 8px !important; }
.input-group .form-control { border-radius: 0 !important; }
.input-group .btn-outline-secondary { border-radius: 0 8px 8px 0 !important; }
</style>

<script>
function togglePwd(fieldId, btn) {
    var input = document.getElementById(fieldId);
    var icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
@endsection
