<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream:  #F5F0E8;
            --brown:  #3D2B1F;
            --gold:   #C8960C;
            --rust:   #A63D2F;
            --sage:   #4A6741;
            --shadow: rgba(61,43,31,0.18);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: url("https://img.freepik.com/premium-photo/too-many-books-library-library-inside-modern-library-interior-inside_179935-62265.jpg")
                        center / cover no-repeat;
            opacity: 0.35;
            pointer-events: none;
        }

        .card {
            background: #fff;
            border-radius: 22px;
            padding: 52px 56px;
            box-shadow: 0 20px 60px var(--shadow);
            width: 100%;
            max-width: 440px;
            position: relative;
            border-top: 6px solid var(--brown);
        }

        .card::before {
            content: '';
            position: absolute;
            top: -6px; left: 50%;
            transform: translateX(-50%);
            width: 72px; height: 6px;
            background: var(--gold);
            border-radius: 0 0 4px 4px;
        }

        .logo {
            font-size: 48px;
            display: block;
            text-align: center;
            margin-bottom: 14px;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            color: var(--brown);
            text-align: center;
            line-height: 1.2;
            margin-bottom: 6px;
        }

        .subtitle {
            text-align: center;
            color: #999;
            font-size: 0.85rem;
            margin-bottom: 32px;
            letter-spacing: 0.03em;
        }

        /* ── ALERT BOXES ── */
        .alert {
            padding: 13px 18px;
            border-radius: 10px;
            margin-bottom: 22px;
            font-size: 0.88rem;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        /* Pesan "Login terlebih dahulu!" (syarat Modul 7) */
        .alert-warning {
            background: #fef3c7;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        /* ── FORM ── */
        .field { margin-bottom: 20px; }

        .field label {
            display: block;
            font-weight: 600;
            font-size: 0.88rem;
            color: var(--brown);
            margin-bottom: 7px;
        }

        .field input {
            width: 100%;
            padding: 13px 16px;
            border: 1.5px solid #ddd;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            color: #333;
            transition: all 0.18s;
            outline: none;
        }

        .field input:focus {
            border-color: var(--brown);
            box-shadow: 0 0 0 3px rgba(61,43,31,0.08);
        }

        .field input.input-error {
            border-color: #ef4444;
        }

        .field .error-msg {
            margin-top: 5px;
            font-size: 0.8rem;
            color: #dc2626;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--brown);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.22s ease;
            margin-top: 4px;
            letter-spacing: 0.03em;
        }

        .btn-login:hover {
            background: #5a3d2b;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--shadow);
        }

        .footer-note {
            text-align: center;
            margin-top: 28px;
            font-size: 0.76rem;
            color: #ccc;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="card">
    <span class="logo">📚</span>
    <h1>Perpustakaan Digital</h1>
    <p class="subtitle">Silakan login untuk melanjutkan</p>

    @if(session('warning'))
        <div class="alert alert-warning">
            ⚠️ {{ session('warning') }}
        </div>
    @endif

    {{-- Error login gagal --}}
    @if($errors->has('login'))
        <div class="alert alert-error">
            ❌ {{ $errors->first('login') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.proses') }}">
        @csrf

        {{-- Email --}}
        <div class="field">
            <label for="email">Email</label>
            <input
                type="text"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                autocomplete="email"
                class="{{ $errors->has('email') ? 'input-error' : '' }}"
            >
            @error('email')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="field">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
                class="{{ $errors->has('password') ? 'input-error' : '' }}"
            >
            @error('password')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-login">Masuk</button>
    </form>

    <p class="footer-note">ERISCHA MARSELA 2410817120022</p>
</div>

</body>
</html>
