<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QAMS &mdash; Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
            overflow: hidden;
            padding: 20px;
        }

        /* Animated gradient blobs */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            animation: float 8s ease-in-out infinite;
            pointer-events: none;
        }
        .blob-1 { width: 500px; height: 500px; background: #6366f1; top: -100px; left: -100px; animation-delay: 0s; }
        .blob-2 { width: 400px; height: 400px; background: #a78bfa; bottom: -80px; right: -80px; animation-delay: 2s; }
        .blob-3 { width: 300px; height: 300px; background: #38bdf8; top: 50%; left: 50%; transform: translate(-50%,-50%); animation-delay: 4s; }

        @keyframes float {
            0%, 100% { transform: scale(1) translate(0,0); }
            33%       { transform: scale(1.05) translate(15px,-10px); }
            66%       { transform: scale(0.97) translate(-10px,15px); }
        }

        /* Card */
        .login-wrap {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 440px;
        }

        .login-card {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            padding: 42px 38px;
            box-shadow: 0 32px 80px rgba(0,0,0,0.5);
        }

        /* Brand */
        .brand-logo {
            width: 66px; height: 66px;
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px;
            box-shadow: 0 8px 28px rgba(99,102,241,0.45);
        }
        .brand-logo i { font-size: 1.9rem; color: #fff; }

        .brand-title {
            font-size: 1.9rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }
        .brand-sub {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.4);
            letter-spacing: 0.3px;
        }

        /* Input group */
        .input-icon-wrap {
            position: relative;
        }
        .input-icon-wrap .inp-icon {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            font-size: 1rem;
            pointer-events: none;
        }
        .input-glass {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 11px;
            color: #fff;
            font-size: 0.93rem;
            padding: 12px 14px 12px 40px;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }
        .input-glass::placeholder { color: rgba(255,255,255,0.28); }
        .input-glass:focus {
            border-color: #6366f1;
            background: rgba(99,102,241,0.08);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
        }
        .input-glass:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 100px #1e2040 inset;
            -webkit-text-fill-color: #fff;
        }

        .field-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: rgba(255,255,255,0.55);
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 7px;
        }

        /* Submit */
        .btn-signin {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            color: #fff;
            font-size: 0.97rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(99,102,241,0.4);
            letter-spacing: 0.3px;
        }
        .btn-signin:hover {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            box-shadow: 0 6px 28px rgba(99,102,241,0.55);
            transform: translateY(-1px);
        }
        .btn-signin:active { transform: translateY(0); }

        /* Alert */
        .auth-alert {
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.25);
            border-radius: 10px;
            color: #fca5a5;
            padding: 11px 14px;
            font-size: 0.87rem;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .auth-alert.info {
            background: rgba(99,102,241,0.12);
            border-color: rgba(99,102,241,0.25);
            color: #a5b4fc;
        }

        /* Setup link */
        .setup-link {
            color: rgba(255,255,255,0.35);
            font-size: 0.8rem;
            text-decoration: none;
            display: flex; align-items: center; gap: 5px;
            justify-content: center;
            transition: color 0.2s;
        }
        .setup-link:hover { color: rgba(255,255,255,0.65); }

        @media (max-width: 480px) {
            .login-card { padding: 30px 22px; border-radius: 18px; }
            .brand-title { font-size: 1.6rem; }
        }
    </style>
</head>
<body>
    <!-- Background blobs -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="login-wrap">
        <div class="login-card">
            <!-- Brand -->
            <div class="text-center mb-4">
                <div class="brand-logo">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div class="brand-title">QAMS</div>
                <div class="brand-sub">Quiz &amp; Assignment Management</div>
            </div>

            @if(session('info'))
                <div class="auth-alert info"><i class="bi bi-info-circle-fill"></i>{{ session('info') }}</div>
            @endif
            @if($errors->any())
                <div class="auth-alert"><i class="bi bi-exclamation-triangle-fill"></i>{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-3">
                    <label class="field-label">Username</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person-fill inp-icon"></i>
                        <input type="text" name="username" class="input-glass"
                               value="{{ old('username') }}" required autofocus
                               placeholder="Enter your username">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="field-label">Password</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock-fill inp-icon"></i>
                        <input type="password" name="password" class="input-glass"
                               required placeholder="Enter your password">
                    </div>
                </div>

                <button type="submit" class="btn-signin mb-3">
                    <i class="bi bi-box-arrow-in-right"></i>Sign In
                </button>
            </form>

            @if(!\App\Models\User::where('role', 'admin')->exists())
            <div class="text-center mt-3">
                <a href="{{ route('setup') }}" class="setup-link">
                    <i class="bi bi-person-plus"></i> First time? Create admin account
                </a>
            </div>
            @endif
        </div>

        <p class="text-center mt-3" style="color:rgba(255,255,255,0.2);font-size:0.75rem;">
            &copy; {{ date('Y') }} QAMS &mdash; Secure Educational Platform
        </p>
    </div>
</body>
</html>
