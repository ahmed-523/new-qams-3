<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QAMS &mdash; Create Admin Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            display: flex; align-items: center; justify-content: center;
            background: #0f172a;
            overflow: hidden;
            padding: 20px;
        }
        .blob { position: fixed; border-radius: 50%; filter: blur(80px); opacity: 0.2; pointer-events: none; }
        .blob-1 { width: 500px; height: 500px; background: #6366f1; top: -100px; right: -100px; }
        .blob-2 { width: 350px; height: 350px; background: #a78bfa; bottom: -60px; left: -60px; }

        .setup-wrap { position: relative; z-index: 2; width: 100%; max-width: 460px; }

        .setup-card {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow: 0 32px 80px rgba(0,0,0,0.5);
        }
        .brand-logo {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 6px 24px rgba(99,102,241,0.4);
        }
        .brand-logo i { font-size: 1.7rem; color: #fff; }
        .brand-title { font-size: 1.7rem; font-weight: 800; color: #fff; margin-bottom: 4px; }
        .brand-sub   { font-size: 0.8rem; color: rgba(255,255,255,0.38); }

        .setup-notice {
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.2);
            border-radius: 10px;
            color: #a5b4fc;
            padding: 10px 14px;
            font-size: 0.82rem;
            margin-bottom: 20px;
        }

        .field-label { display: block; font-size: 0.77rem; font-weight: 600; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.7px; margin-bottom: 7px; }
        .input-icon-wrap { position: relative; }
        .inp-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.28); font-size: 0.95rem; pointer-events: none; }
        .input-glass {
            width: 100%; background: rgba(255,255,255,0.06); border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 10px; color: #fff; font-size: 0.91rem; padding: 11px 14px 11px 38px;
            font-family: 'Inter', sans-serif; transition: all 0.2s; outline: none;
        }
        .input-glass::placeholder { color: rgba(255,255,255,0.24); }
        .input-glass:focus { border-color: #6366f1; background: rgba(99,102,241,0.08); box-shadow: 0 0 0 3px rgba(99,102,241,0.18); }

        .auth-alert { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.22); border-radius: 10px; color: #fca5a5; padding: 10px 14px; font-size: 0.86rem; margin-bottom: 16px; }

        .btn-setup {
            width: 100%; padding: 13px; border: none; border-radius: 11px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            color: #fff; font-size: 0.96rem; font-weight: 700;
            font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(99,102,241,0.4);
        }
        .btn-setup:hover { background: linear-gradient(135deg, #4f46e5, #6366f1); transform: translateY(-1px); box-shadow: 0 6px 28px rgba(99,102,241,0.5); }

        @media (max-width: 480px) { .setup-card { padding: 28px 20px; border-radius: 18px; } }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="setup-wrap">
        <div class="setup-card">
            <div class="text-center mb-4">
                <div class="brand-logo"><i class="bi bi-mortarboard-fill"></i></div>
                <div class="brand-title">QAMS Setup</div>
                <div class="brand-sub">Create your administrator account</div>
            </div>

            <div class="setup-notice">
                <i class="bi bi-shield-check me-1"></i>
                <strong>First-time setup.</strong> This page is only available once. All future users are registered from the admin panel.
            </div>

            @if($errors->any())
                <div class="auth-alert"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('setup.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="field-label">Full Name</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person-fill inp-icon"></i>
                        <input type="text" name="name" class="input-glass" value="{{ old('name') }}" required placeholder="e.g. Dr. Ahmad Khan">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="field-label">Username</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-at inp-icon"></i>
                        <input type="text" name="username" class="input-glass" value="{{ old('username') }}" required placeholder="e.g. admin">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="field-label">Password</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock-fill inp-icon"></i>
                        <input type="password" name="password" class="input-glass" required placeholder="Minimum 6 characters">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="field-label">Confirm Password</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock-fill inp-icon"></i>
                        <input type="password" name="password_confirmation" class="input-glass" required placeholder="Repeat password">
                    </div>
                </div>
                <button type="submit" class="btn-setup">
                    <i class="bi bi-shield-check"></i>Create Admin Account
                </button>
            </form>
        </div>
    </div>
</body>
</html>
