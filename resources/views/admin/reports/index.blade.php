@extends('layouts.app')
@section('title', 'Reports')
@section('page-title', 'Reports Overview')
@section('sidebar')
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
    <a href="{{ route('admin.classes.index') }}"><i class="bi bi-building"></i>Classes</a>
    <a href="{{ route('admin.subjects.index') }}"><i class="bi bi-book"></i>Subjects</a>
    <a href="{{ route('admin.students.index') }}"><i class="bi bi-people"></i>Students</a>
    <a href="{{ route('admin.teachers.index') }}"><i class="bi bi-person-badge"></i>Teachers</a>
    <a href="{{ route('admin.reports') }}" class="active"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')

<div class="mb-4">
    <div style="font-size:1.15rem;font-weight:700;color:#0f172a;">Reports & Analytics</div>
    <div style="font-size:0.82rem;color:#64748b;margin-top:2px;">Generate detailed performance reports for students and teachers.</div>
</div>

<div class="row g-4">
    <div class="col-12 col-md-6">
        <div class="report-card">
            <div class="rc-icon" style="background:linear-gradient(135deg,#6366f1,#a78bfa);">
                <i class="bi bi-people-fill"></i>
            </div>
            <h5 class="fw-700 mt-3 mb-2">Student Reports</h5>
            <p class="text-muted mb-4" style="font-size:0.88rem;line-height:1.6;">
                View quiz scores, assignment grades, and overall academic performance per student. Filter by class or individual student.
            </p>
            <div class="d-flex gap-3 mb-4">
                <div class="rc-stat">
                    <i class="bi bi-journal-check" style="color:#6366f1;"></i>
                    <span>Quiz Results</span>
                </div>
                <div class="rc-stat">
                    <i class="bi bi-file-earmark-text" style="color:#10b981;"></i>
                    <span>Assignment Grades</span>
                </div>
                <div class="rc-stat">
                    <i class="bi bi-graph-up" style="color:#f59e0b;"></i>
                    <span>Performance</span>
                </div>
            </div>
            <a href="{{ route('admin.reports.students') }}" class="btn btn-primary w-100">
                <i class="bi bi-graph-up me-2"></i>View Student Reports
            </a>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="report-card">
            <div class="rc-icon" style="background:linear-gradient(135deg,#0284c7,#38bdf8);">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <h5 class="fw-700 mt-3 mb-2">Teacher Reports</h5>
            <p class="text-muted mb-4" style="font-size:0.88rem;line-height:1.6;">
                View quizzes created, assignments uploaded, and overall teaching activity per teacher. Monitor engagement and workload.
            </p>
            <div class="d-flex gap-3 mb-4">
                <div class="rc-stat">
                    <i class="bi bi-journal-plus" style="color:#0284c7;"></i>
                    <span>Quizzes Created</span>
                </div>
                <div class="rc-stat">
                    <i class="bi bi-upload" style="color:#6366f1;"></i>
                    <span>Assignments</span>
                </div>
                <div class="rc-stat">
                    <i class="bi bi-activity" style="color:#10b981;"></i>
                    <span>Activity</span>
                </div>
            </div>
            <a href="{{ route('admin.reports.teachers') }}" class="btn btn-primary w-100">
                <i class="bi bi-bar-chart me-2"></i>View Teacher Reports
            </a>
        </div>
    </div>
</div>

<style>
.fw-700 { font-weight:700!important; }
.report-card {
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:16px;
    padding:28px;
    height:100%;
    transition:box-shadow 0.2s,transform 0.2s;
}
.report-card:hover { box-shadow:0 10px 40px rgba(0,0,0,0.1);transform:translateY(-2px); }
.rc-icon {
    width:60px;height:60px;border-radius:16px;
    display:flex;align-items:center;justify-content:center;
    font-size:1.6rem;color:#fff;
    box-shadow:0 6px 20px rgba(0,0,0,0.15);
}
.rc-stat {
    display:flex;align-items:center;gap:5px;
    font-size:0.78rem;color:#64748b;font-weight:500;
}
</style>
@endsection
