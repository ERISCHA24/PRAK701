<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan') – Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream:  #F5F0E8;
            --brown:  #3D2B1F;
            --gold:   #C8960C;
            --rust:   #A63D2F;
            --sage:   #4A6741;
            --blue:   #1e4d8c;
            --light:  #FAF8F4;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
            display: flex;
        }

        /* ── SIDEBAR ────────────────────────────────────────────────────────── */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--brown);
            padding: 32px 20px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar-brand {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 1.2rem;
            padding-bottom: 18px;
            margin-bottom: 4px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sidebar-user {
            background: rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 10px 13px;
            margin-bottom: 10px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.55);
        }
        .sidebar-user strong {
            display: block;
            color: #fff;
            font-size: 0.9rem;
            margin-bottom: 1px;
        }
        .sidebar-section {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.35);
            padding: 10px 14px 4px;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 13px;
            color: rgba(255,255,255,0.72);
            text-decoration: none;
            border-radius: 9px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.18s ease;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,0.12);
            color: #fff;
            transform: translateX(3px);
        }
        .sidebar .spacer { flex: 1; min-height: 16px; }
        .sidebar .btn-logout {
            display: flex;
            align-items: center;
            gap: 9px;
            width: 100%;
            padding: 10px 13px;
            background: rgba(166,61,47,0.22);
            color: #ffb3aa;
            border: none;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .sidebar .btn-logout:hover {
            background: var(--rust);
            color: #fff;
        }

        /* ── MAIN ────────────────────────────────────────────────────────────── */
        .main {
            flex: 1;
            padding: 40px 48px;
            overflow-y: auto;
            min-width: 0;
        }
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            color: var(--brown);
        }

        /* ── ALERTS ─────────────────────────────────────────────────────────── */
        .alert {
            padding: 13px 20px;
            border-radius: 11px;
            margin-bottom: 22px;
            font-weight: 500;
            font-size: 0.91rem;
            display: flex;
            align-items: flex-start;
            gap: 9px;
        }
        .alert-success  { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-warning  { background: #fef3c7; color: #92400e; border-left: 4px solid #f59e0b; }
        .alert-error    { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }
        .alert ul       { padding-left: 18px; margin-top: 5px; }

        /* ── TABLE ───────────────────────────────────────────────────────────── */
        .table-wrap {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(61,43,31,0.07);
        }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: var(--brown); color: #fff; }
        thead th {
            padding: 14px 18px;
            text-align: left;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
        tbody tr { border-bottom: 1px solid #f2ede4; transition: background 0.13s; }
        tbody tr:hover { background: var(--light); }
        tbody td { padding: 13px 18px; font-size: 0.9rem; color: #444; vertical-align: middle; }
        .empty-state { text-align: center; padding: 52px; color: #aaa; font-size: 0.93rem; }

        /* ── BADGES ─────────────────────────────────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.76rem;
            font-weight: 700;
        }
        .badge-default  { background: #ede8df; color: var(--brown); }
        .badge-aktif    { background: #d1fae5; color: #065f46; }
        .badge-selesai  { background: #e0e7ff; color: #3730a3; }
        .badge-overdue  { background: #fee2e2; color: #991b1b; }
        .badge-today    { background: #fef3c7; color: #92400e; }

        /* ── BUTTONS ─────────────────────────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.16s ease;
            font-family: 'DM Sans', sans-serif;
            white-space: nowrap;
        }
        .btn-primary { background: var(--brown); color: #fff; }
        .btn-primary:hover { background: #5a3d2b; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(61,43,31,0.22); }
        .btn-edit    { background: var(--gold); color: var(--brown); }
        .btn-edit:hover { opacity: 0.88; transform: translateY(-1px); }
        .btn-delete  { background: var(--rust); color: #fff; }
        .btn-delete:hover { opacity: 0.88; transform: translateY(-1px); }
        .btn-success { background: var(--sage); color: #fff; }
        .btn-success:hover { background: #3a5432; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(74,103,65,0.22); }
        .btn-blue    { background: var(--blue); color: #fff; }
        .btn-blue:hover { background: #163a6e; transform: translateY(-1px); }
        .btn-disabled { background: #e5e7eb; color: #9ca3af; cursor: not-allowed; pointer-events: none; }

        /* ── FORM CARD ────────────────────────────────────────────────────────── */
        .form-card {
            background: #fff;
            border-radius: 18px;
            padding: 44px;
            box-shadow: 0 4px 20px rgba(61,43,31,0.07);
            border-top: 5px solid var(--sage);
            max-width: 700px;
            margin: 0 auto;
        }
        .form-card h1 { font-family: 'Playfair Display', serif; font-size: 1.7rem; color: var(--brown); margin-bottom: 5px; }
        .form-card .sub { color: #999; font-size: 0.86rem; margin-bottom: 28px; }
        .field { margin-bottom: 20px; }
        .field label { display: block; font-weight: 600; font-size: 0.86rem; color: var(--brown); margin-bottom: 6px; }
        .field label .req { color: var(--rust); }
        .field input[type="text"],
        .field input[type="number"],
        .field input[type="email"],
        .field input[type="password"],
        .field input[type="date"],
        .field input[type="datetime-local"],
        .field textarea,
        .field select {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #ddd;
            border-radius: 9px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.93rem;
            color: #333;
            transition: all 0.17s;
            outline: none;
            background: #fff;
        }
        .field input:focus,
        .field textarea:focus,
        .field select:focus { border-color: var(--sage); box-shadow: 0 0 0 3px rgba(74,103,65,0.1); }
        .field .input-error { border-color: #ef4444 !important; }
        .field .error-msg { margin-top: 4px; font-size: 0.79rem; color: #dc2626; }
        .field textarea { resize: vertical; min-height: 80px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-actions { display: flex; gap: 10px; margin-top: 6px; }
        .hint { font-size: 0.76rem; color: #999; margin-top: 4px; }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── SIDEBAR ── --}}
<aside class="sidebar">
    <div class="sidebar-brand">📚 Perpustakaan</div>

    @if(session('user'))
    <div class="sidebar-user">
        <strong>{{ session('user.username') }}</strong>
        {{ session('user.email') }}
    </div>
    @endif

    <div class="sidebar-section">Menu Utama</div>
    <a href="{{ route('buku.index') }}"
       class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
        📖 Data Buku
    </a>
    <a href="{{ route('member.index') }}"
       class="{{ request()->routeIs('member.*') ? 'active' : '' }}">
        👤 Data Member
    </a>
    <a href="{{ route('peminjaman.index') }}"
       class="{{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
        🔖 Peminjaman
    </a>

    <div class="spacer"></div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">🚪 Logout</button>
    </form>
</aside>

{{-- ── MAIN CONTENT ── --}}
<main class="main">

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning">⚠️ {{ session('warning') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    @yield('content')
</main>

@stack('scripts')
</body>
</html>