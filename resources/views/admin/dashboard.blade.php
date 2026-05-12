@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('sidebar')
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>Dashboard
    </a>
    <a href="{{ route('admin.classes.index') }}"><i class="bi bi-building"></i>Classes</a>
    <a href="{{ route('admin.subjects.index') }}"><i class="bi bi-book"></i>Subjects</a>
    <a href="{{ route('admin.students.index') }}"><i class="bi bi-people"></i>Students</a>
    <a href="{{ route('admin.teachers.index') }}"><i class="bi bi-person-badge"></i>Teachers</a>
    <a href="{{ route('admin.reports') }}"><i class="bi bi-bar-chart-line"></i>Reports</a>
@endsection

@section('content')

{{-- Welcome banner --}}
<div class="welcome-banner mb-4">
    <div class="wb-content">
        <div class="wb-icon"><i class="bi bi-shield-check"></i></div>
        <div>
            <div class="wb-title">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}! 👋</div>
            <div class="wb-sub">Here's a snapshot of your institution's activity today.</div>
        </div>
    </div>
    <div class="wb-date">
        <i class="bi bi-calendar3"></i>{{ now()->format('l, d M Y') }}
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#ede9fe;color:#7c3aed;">
                <i class="bi bi-people-fill"></i>
            </div>
            <h2 class="fw-800" style="color:#7c3aed;">{{ $stats['total_students'] }}</h2>
            <p>Students</p>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#dcfce7;color:#16a34a;">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <h2 class="fw-800" style="color:#16a34a;">{{ $stats['total_teachers'] }}</h2>
            <p>Teachers</p>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#e0f2fe;color:#0284c7;">
                <i class="bi bi-building-fill"></i>
            </div>
            <h2 class="fw-800" style="color:#0284c7;">{{ $stats['total_classes'] }}</h2>
            <p>Classes</p>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#fef9c3;color:#ca8a04;">
                <i class="bi bi-book-fill"></i>
            </div>
            <h2 class="fw-800" style="color:#ca8a04;">{{ $stats['total_subjects'] }}</h2>
            <p>Subjects</p>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#fee2e2;color:#dc2626;">
                <i class="bi bi-journal-check"></i>
            </div>
            <h2 class="fw-800" style="color:#dc2626;">{{ $stats['total_quizzes'] }}</h2>
            <p>Quizzes</p>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="card stat-card p-3">
            <div class="stat-icon" style="background:#f0fdf4;color:#15803d;">
                <i class="bi bi-file-earmark-text-fill"></i>
            </div>
            <h2 class="fw-800" style="color:#15803d;">{{ $stats['total_assignments'] }}</h2>
            <p>Assignments</p>
        </div>
    </div>
</div>

{{-- Recent activity --}}
<div class="row g-4">
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#ede9fe;color:#7c3aed;"><i class="bi bi-journal-check"></i></span>
                <strong>Recent Quizzes</strong>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($recent_quizzes as $quiz)
                    <li class="list-group-item d-flex justify-content-between align-items-center gap-2 flex-wrap">
                        <span class="fw-medium">{{ $quiz->title }}</span>
                        <span class="badge" style="background:#ede9fe;color:#6d28d9;font-size:0.73rem;">
                            {{ $quiz->deadline->format('d M Y') }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No quizzes yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <span class="card-hdr-icon" style="background:#fef9c3;color:#a16207;"><i class="bi bi-file-earmark-text-fill"></i></span>
                <strong>Recent Assignments</strong>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($recent_assignments as $a)
                    <li class="list-group-item d-flex justify-content-between align-items-center gap-2 flex-wrap">
                        <span class="fw-medium">{{ $a->title }}</span>
                        <span class="badge" style="background:#fef9c3;color:#a16207;font-size:0.73rem;">
                            {{ $a->deadline->format('d M Y') }}
                        </span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No assignments yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<style>
.fw-800 { font-weight: 800 !important; }

/* Welcome Banner */
.welcome-banner {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #1e3a5f 100%);
    border-radius: 16px;
    padding: 22px 26px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    box-shadow: 0 4px 20px rgba(99,102,241,0.25);
}
.wb-content { display: flex; align-items: center; gap: 16px; }
.wb-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,0.12);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: #a5b4fc;
    flex-shrink: 0;
}
.wb-title { font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 3px; }
.wb-sub   { font-size: 0.82rem; color: rgba(255,255,255,0.5); }
.wb-date  { font-size: 0.8rem; color: rgba(255,255,255,0.45); white-space: nowrap; }

/* Card header icon */
.card-hdr-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
}
</style>
@endsection
