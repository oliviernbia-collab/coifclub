<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.employee_workspace'))</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --bg: #0b111f;
    --surface: #111827;
    --surface-soft: #161e2d;
    --text: #f1f5f9;
    --muted: #94a3b8;
    --border: rgba(148,163,184,0.18);
    --primary: #d4af37;
    --primary-dark: #b89022;
    --primary-lt: #f5d06f;
    --accent: #f5d06f;
    --radius: 22px;
    --shadow: 0 20px 50px rgba(0,0,0,0.18);
    --sidebar-width: 290px;
}

* { box-sizing: border-box; }

body {
    margin: 0;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    background: radial-gradient(circle at top, rgba(212,175,55,0.05), transparent 30%),
                linear-gradient(180deg, #08101f 0%, #05070f 100%);
    color: var(--text);
    overflow-x: hidden;
}

a { color: inherit; text-decoration: none; }

/* ── Sidebar ── */
.sidebar {
    width: var(--sidebar-width);
    position: fixed;
    top: 78px; left: 0; bottom: 0;
    padding: 0;
    background: #111827;
    border-right: 1px solid rgba(139,92,246,.2);
    display: flex;
    flex-direction: column;
    z-index: 50;
    overflow: hidden;
}

.sidebar-nav {
    flex: 1;
    overflow-y: auto;
    padding: 14px 14px 8px;
    scrollbar-width: thin;
    scrollbar-color: rgba(139,92,246,.3) transparent;
}
.sidebar-nav::-webkit-scrollbar { width: 3px; }
.sidebar-nav::-webkit-scrollbar-thumb { background: rgba(139,92,246,.3); border-radius: 4px; }

.sidebar .menu-title {
    text-transform: uppercase;
    letter-spacing: 0.18em;
    font-size: 0.68rem;
    font-weight: 600;
    color: rgba(255,255,255,.22);
    margin: 8px 0 6px;
    padding: 0 2px;
}

.sidebar .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 14px;
    border-radius: 12px;
    color: rgba(255,255,255,.58);
    transition: all 0.25s ease;
    font-weight: 500;
    font-size: 13px;
    margin-bottom: 2px;
}

.sidebar .nav-link i { width: 22px; text-align: center; font-size: 1.05rem; }

.sidebar .nav-link:hover {
    transform: translateX(3px);
    color: white;
    background: rgba(255,255,255,.07);
}

.sidebar .nav-link.active {
    color: #fff;
    background: linear-gradient(135deg, #6d28d9, #8b5cf6);
    box-shadow: 0 4px 18px rgba(139,92,246,.35);
}

.sidebar .nav-section { display: flex; flex-direction: column; gap: 0; }
.sidebar-footer {
    padding: 12px 14px 18px;
    border-top: 1px solid rgba(255,255,255,.06);
    flex-shrink: 0;
}

.sidebar-user-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 14px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.07);
    margin-bottom: 10px;
}
.sidebar-user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 1.5px solid rgba(139,92,246,.45);
    flex-shrink: 0;
}
.sidebar-user-name {
    font-size: 12.5px;
    font-weight: 700;
    color: #fff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.sidebar-user-role {
    font-size: 10px;
    color: rgba(255,255,255,.38);
    margin-top: 1px;
}

.sidebar-footer .btn-emp-logout {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    width: 100%;
    padding: 11px 14px;
    border-radius: 12px;
    border: 1px solid rgba(239,68,68,.22);
    background: rgba(239,68,68,.07);
    color: rgba(239,68,68,.75);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s, color .2s, border-color .2s, box-shadow .2s;
}
.sidebar-footer .btn-emp-logout i {
    font-size: 14px;
    transition: transform .2s;
}
.sidebar-footer .btn-emp-logout:hover {
    background: rgba(239,68,68,.16);
    border-color: rgba(239,68,68,.4);
    color: #EF4444;
    box-shadow: 0 4px 16px rgba(239,68,68,.12);
}
.sidebar-footer .btn-emp-logout:hover i {
    transform: translateX(3px);
}

/* ── Content ── */
.content {
    margin-left: var(--sidebar-width);
    padding: 32px;
    min-height: 100vh;
    background: transparent;
}

/* ── Topbar ── */
.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding: 22px 26px;
    border-radius: var(--radius);
    background: rgba(14,10,28,.92);
    border: 1px solid rgba(212,175,55,.12);
    box-shadow: 0 4px 24px rgba(0,0,0,.3);
    margin-bottom: 26px;
    backdrop-filter: blur(20px);
}

.topbar h1 { margin: 0; font-size: 1.35rem; letter-spacing: -0.03em; }
.topbar small { color: var(--muted); }

.page-title    { font-size: 1.3rem; margin: 0; font-weight: 700; color: #fff; }
.page-subtitle { color: rgba(255,255,255,.45); font-size: 0.95rem; }

.profile-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 16px;
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,.08);
    background: rgba(255,255,255,.05);
}

.profile-card img {
    width: 48px; height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid rgba(255,255,255,.12);
}

.profile-card .profile-meta { display: flex; flex-direction: column; gap: 2px; }
.profile-card .profile-meta strong { font-size: 0.95rem; color: #fff; }
.profile-card .profile-meta span  { color: rgba(255,255,255,.45); font-size: 0.82rem; }

/* ── Admin-style cards ── */
.admin-card {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: var(--radius);
    box-shadow: 0 4px 24px rgba(0,0,0,.25);
    padding: 26px;
}

.admin-card h3 { margin-top: 0; margin-bottom: 18px; font-size: 1.05rem; letter-spacing: -0.02em; color: #fff; }

.admin-card table { width: 100%; border-collapse: collapse; color: rgba(255,255,255,.85); }
.admin-card table th,
.admin-card table td {
    padding: 14px 12px;
    border-bottom: 1px solid rgba(148,163,184,.1);
    vertical-align: middle;
}
.admin-card table th {
    color: rgba(255,255,255,.5);
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    background: rgba(212,175,55,.08);
}
.admin-card table tbody tr:hover { background: rgba(255,255,255,.03); }

.btn-admin {
    background: linear-gradient(135deg, #d4af37, #f5d06f);
    border: none;
    color: #111827;
    border-radius: 14px;
    padding: 11px 20px;
    font-weight: 700;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.btn-admin:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 35px rgba(212,175,55,.30);
    color: #111827;
}

/* ── Cart link ── */
.emp-cart {
    position: relative; width: 36px; height: 36px; border-radius: 50%;
    border: 1.5px solid rgba(255,255,255,.18); background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.65);
    display: inline-flex; align-items: center; justify-content: center;
    text-decoration: none; transition: .2s; flex-shrink: 0;
}
.emp-cart:hover { border-color: #e83e8c; color: #e83e8c; background: rgba(232,62,140,.1); }
.emp-cart-badge {
    position: absolute; top: -4px; right: -4px;
    min-width: 16px; height: 16px; border-radius: 999px;
    background: #e83e8c; color: #fff;
    font-size: 9px; font-weight: 700; line-height: 16px; text-align: center;
    padding: 0 3px; border: 2px solid #1a1a2e;
}

/* ── Lang pill dropdown ── */
.emp-lang-wrap { position: relative; }
.emp-lang-pill {
    display: flex; align-items: center; gap: 5px;
    border: 1.5px solid rgba(255,255,255,.18); border-radius: 20px;
    padding: 5px 11px 5px 8px; font-size: 13px; font-weight: 600;
    color: rgba(255,255,255,.75); cursor: pointer; background: rgba(255,255,255,.06);
    transition: border-color .2s; user-select: none; white-space: nowrap;
}
.emp-lang-pill:hover { border-color: rgba(255,255,255,.4); }
.emp-lang-flag  { font-size: 16px; line-height: 1; }
.emp-lang-code  { font-size: 12.5px; font-weight: 700; color: rgba(255,255,255,.75); }
.emp-lang-chevron { font-size: 9px; color: rgba(255,255,255,.4); margin-left: 1px; transition: transform .2s; }
.emp-lang-wrap.open .emp-lang-chevron { transform: rotate(180deg); }
.emp-lang-drop {
    display: none; position: absolute; top: calc(100% + 6px); right: 0;
    background: #fff; border: 1px solid #e8e8e8; border-radius: 12px;
    min-width: 140px; box-shadow: 0 8px 28px rgba(0,0,0,.11);
    z-index: 9999; overflow: hidden; padding: 4px 0;
}
.emp-lang-wrap.open .emp-lang-drop { display: block; }
.emp-lang-opt {
    display: flex; align-items: center; gap: 9px; padding: 10px 16px;
    font-size: 13.5px; font-weight: 500; color: #444;
    text-decoration: none; transition: background .15s;
}
.emp-lang-opt:hover { background: rgba(232,62,140,.07); color: #e83e8c; }
.emp-lang-opt.active { color: #e83e8c; font-weight: 700; }
.emp-lang-opt-flag { font-size: 18px; }

/* ── Topbar actions ── */
.topbar-actions { display: flex; align-items: center; gap: 14px; }

/* ── Mobile topbar ── */
.mob-topbar {
    display: none;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    background: #0f172a;
    border-bottom: 1px solid rgba(139,92,246,.2);
    position: sticky;
    top: 0;
    z-index: 100;
}

.burger-btn {
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(148,163,184,.15);
    border-radius: 10px;
    width: 40px; height: 40px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: background .2s;
    color: var(--text);
    font-size: 18px;
    flex-shrink: 0;
}
.burger-btn:hover { background: rgba(139,92,246,.18); }

/* ── Drawer overlay ── */
.drawer-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.55);
    z-index: 9998;
    opacity: 0;
    transition: opacity .3s;
    backdrop-filter: blur(2px);
    pointer-events: none;
}
.drawer-overlay.visible { opacity: 1; pointer-events: auto; }

/* ── Mobile drawer ── */
.mobile-drawer {
    position: fixed;
    top: 0; left: 0; bottom: 0;
    width: var(--sidebar-width);
    background: #111827;
    border-right: 1px solid rgba(139,92,246,.2);
    z-index: 9999;
    transform: translateX(-100%);
    transition: transform .35s cubic-bezier(.4,0,.2,1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.mobile-drawer.open { transform: translateX(0); }

/* ── Mobile drawer ── */
.drawer-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 18px 16px;
    border-bottom: 1px solid rgba(139,92,246,.28);
    flex-shrink: 0;
}
.drawer-brand { display: flex; align-items: center; gap: 12px; }
.drawer-brand img {
    width: 44px; height: 44px;
    border-radius: 12px; object-fit: cover;
    border: 2px solid #8b5cf6;
    box-shadow: 0 0 14px rgba(139,92,246,.3);
}
.drawer-brand-name {
    font-size: 16px; font-weight: 800;
    background: linear-gradient(to right, #8b5cf6, #c4b5fd, #6d28d9);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.drawer-brand-sub {
    font-size: 9px; color: rgba(255,255,255,.38);
    text-transform: uppercase; letter-spacing: .1em; margin-top: 1px;
}
.drawer-close-btn {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: rgba(139,92,246,.12);
    border: 1px solid rgba(139,92,246,.3);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: #a78bfa; font-size: 15px;
    transition: background .2s; flex-shrink: 0;
}
.drawer-close-btn:hover { background: rgba(139,92,246,.25); }

/* Drawer user card */
.drawer-user-card {
    margin: 12px 16px;
    padding: 13px 15px;
    display: flex; align-items: center; gap: 11px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(139,92,246,.22);
    border-radius: 17px;
    flex-shrink: 0;
}
.drawer-user-avatar {
    width: 44px; height: 44px;
    border-radius: 50%; object-fit: cover;
    border: 2px solid #8b5cf6;
    flex-shrink: 0;
}
.drawer-user-name { font-size: 13px; font-weight: 700; color: #fff; }
.drawer-user-role { font-size: 10px; color: #a78bfa; margin-top: 2px; }

.drawer-scroll {
    flex: 1; overflow-y: auto;
    padding: 8px 14px 0;
    scrollbar-width: thin;
    scrollbar-color: rgba(139,92,246,.3) transparent;
}
.drawer-scroll::-webkit-scrollbar { width: 4px; }
.drawer-scroll::-webkit-scrollbar-thumb { background: rgba(139,92,246,.3); border-radius: 4px; }

.drawer-section-label {
    font-size: 9px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .16em;
    color: rgba(255,255,255,.22);
    padding: 12px 8px 6px;
}
.drawer-nav-link {
    display: flex; align-items: center; gap: 13px;
    padding: 13px 14px; border-radius: 14px;
    color: rgba(209,213,219,.9);
    font-size: 14px; font-weight: 500;
    text-decoration: none;
    transition: all .2s; margin-bottom: 3px;
}
.drawer-nav-link i { font-size: 16px; width: 20px; text-align: center; flex-shrink: 0; }
.drawer-nav-link:hover {
    background: linear-gradient(to right, rgba(139,92,246,.15), rgba(255,255,255,.03));
    color: #fff;
    transform: translateX(4px);
}
.drawer-nav-link.active {
    background: linear-gradient(to right, #6d28d9, #8b5cf6);
    color: #fff;
    font-weight: 700;
    box-shadow: 0 8px 24px rgba(139,92,246,.35);
}

/* Lang pills dans le drawer */
.drawer-lang-pills {
    display: flex; gap: 6px;
    padding: 14px 8px 6px;
    border-top: 1px solid rgba(255,255,255,.06);
    margin-top: 8px;
}
.drawer-lang-pill {
    flex: 1; text-align: center;
    padding: 9px 4px;
    border-radius: 10px;
    font-size: 12px; font-weight: 700;
    text-decoration: none;
    transition: background .2s, color .2s;
    background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.6);
    border: 1px solid rgba(255,255,255,.08);
}
.drawer-lang-pill:hover {
    background: rgba(139,92,246,.15);
    color: #c4b5fd;
    border-color: rgba(139,92,246,.3);
}
.drawer-lang-pill.active {
    background: linear-gradient(135deg, #6d28d9, #8b5cf6);
    color: #fff;
    border-color: transparent;
}

.drawer-foot {
    padding: 12px 16px 18px;
    border-top: 1px solid rgba(139,92,246,.18);
    flex-shrink: 0;
}
.drawer-foot .btn-emp-logout {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    width: 100%;
    padding: 13px 14px;
    border-radius: 14px;
    border: 1px solid rgba(236,72,153,.28);
    background: rgba(236,72,153,.08);
    color: rgba(236,72,153,.85);
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    letter-spacing: .01em;
    transition: background .22s, color .22s, border-color .22s, box-shadow .22s;
}
.drawer-foot .btn-emp-logout i {
    font-size: 15px;
    transition: transform .22s;
}
.drawer-foot .btn-emp-logout:hover {
    background: rgba(236,72,153,.17);
    border-color: rgba(236,72,153,.5);
    color: #ec4899;
    box-shadow: 0 4px 20px rgba(236,72,153,.2);
}
.drawer-foot .btn-emp-logout:hover i {
    transform: translateX(4px);
}

/* ── Sidebar desktop — profile card ── */
.sidebar-profile-card {
    padding: 16px 14px 14px;
    border-bottom: 1px solid rgba(255,255,255,.06);
    flex-shrink: 0;
}
.sidebar-profile-inner {
    display: flex; align-items: center; gap: 11px;
    padding: 12px 13px;
    border-radius: 18px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(139,92,246,.22);
}
.sidebar-profile-avatar {
    width: 46px; height: 46px;
    border-radius: 50%; object-fit: cover;
    border: 2px solid rgba(139,92,246,.65);
    box-shadow: 0 0 12px rgba(139,92,246,.25);
    flex-shrink: 0;
}
.sidebar-profile-name {
    font-size: 13px; font-weight: 700; color: #fff;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.sidebar-profile-badge {
    display: inline-flex; align-items: center; gap: 3px;
    margin-top: 4px; padding: 2px 9px;
    border-radius: 999px;
    background: rgba(139,92,246,.15);
    border: 1px solid rgba(139,92,246,.3);
    font-size: 9px; font-weight: 700;
    color: #a78bfa; text-transform: uppercase; letter-spacing: .06em;
}

/* ── Bottom nav (mobile) ── */
.bottom-nav {
    display: none;
    position: fixed;
    bottom: 0; left: 0; right: 0;
    z-index: 450;
    background: rgba(17,24,39,.97);
    backdrop-filter: blur(24px);
    border-top: 1px solid rgba(139,92,246,.2);
    padding: 6px 0 max(10px, env(safe-area-inset-bottom));
    justify-content: space-around;
    align-items: flex-end;
}
.bnav-item {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    text-decoration: none;
    color: rgba(255,255,255,.4);
    font-size: .58rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
    padding: 6px 10px; border-radius: 14px;
    transition: .25s ease; min-width: 52px;
}
.bnav-item i { font-size: 1.15rem; }
.bnav-item.active { color: #a78bfa; }
.bnav-item.active i { filter: drop-shadow(0 0 6px rgba(139,92,246,.55)); }

/* ── Content global overrides ── */
body { background: #08101f !important; color: rgba(255,255,255,.88) !important; padding-top: 78px !important; }

.content h1,.content h2,.content h3,.content h4,.content h5,.content h6 { color: #fff !important; -webkit-text-fill-color: #fff !important; background: none !important; }
.content .page-title { color: #fff !important; }
.content p, .content li, .content small { color: rgba(255,255,255,.55) !important; }
.content label, .content .form-label { color: rgba(255,255,255,.7) !important; }
.content .form-control, .content .form-select { color: #fff !important; background: rgba(255,255,255,.06) !important; border-color: rgba(255,255,255,.12) !important; }
.content .form-control::placeholder { color: rgba(255,255,255,.3) !important; }
.content .input-group-text { color: rgba(255,255,255,.6) !important; background: rgba(255,255,255,.04) !important; border-color: rgba(255,255,255,.12) !important; }
.content .table, .content table { color: rgba(255,255,255,.85) !important; }
.content .table th, .content .table td { color: rgba(255,255,255,.8) !important; border-color: rgba(255,255,255,.06) !important; }
.content table thead th { color: rgba(255,255,255,.6) !important; background: rgba(212,175,55,.08) !important; border-bottom: 2px solid rgba(212,175,55,.2) !important; }
.content table td { color: rgba(255,255,255,.8) !important; border-color: rgba(255,255,255,.06) !important; }
.content table tbody tr:hover { background: rgba(255,255,255,.02) !important; }
.content .card { background: rgba(255,255,255,.04) !important; border: 1px solid rgba(255,255,255,.08) !important; }
.content .card-header, .content .card-body, .content .card-footer { background: transparent !important; color: rgba(255,255,255,.85) !important; border-color: rgba(255,255,255,.06) !important; }
.content .text-muted { color: rgba(255,255,255,.45) !important; }
.content .text-white { color: #fff !important; }
.content .alert-success { color: #4ade80 !important; background: rgba(74,222,128,.1) !important; border-color: rgba(74,222,128,.2) !important; }
.content .alert-danger  { color: #f87171 !important; background: rgba(248,113,113,.08) !important; border-color: rgba(248,113,113,.2) !important; }
.content .alert-warning { color: #fbbf24 !important; background: rgba(251,191,36,.08) !important; border-color: rgba(251,191,36,.2) !important; }
.content .badge.bg-warning { background: rgba(251,191,36,.2) !important; color: #fbbf24 !important; }
.content .badge.bg-success { background: rgba(74,222,128,.15) !important; color: #4ade80 !important; }
.content .badge.bg-danger  { background: rgba(248,113,113,.15) !important; color: #f87171 !important; }
.content .badge.bg-primary { background: rgba(212,175,55,.18) !important; color: #d4af37 !important; }
.content .form-check-label { color: rgba(255,255,255,.7) !important; }
.content hr { border-color: rgba(255,255,255,.08) !important; }
.content .modal-content { background: #111827 !important; border: 1px solid rgba(255,255,255,.1) !important; }
.content .modal-header { border-bottom-color: rgba(255,255,255,.08) !important; }
.content .modal-footer { border-top-color: rgba(255,255,255,.08) !important; }
.content .modal-title { color: #fff !important; }

/* ── Employee-specific dark card ── */
.emp-card-dark {
    background: rgba(255,255,255,.04) !important;
    border: 1px solid rgba(255,255,255,.08) !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 24px rgba(0,0,0,.25) !important;
    overflow: hidden;
}
.emp-card-dark .emp-card-head {
    display: flex; justify-content: space-between; align-items: center;
    padding: 18px 22px;
    border-bottom: 1px solid rgba(255,255,255,.06) !important;
}
.emp-card-dark .emp-card-title { font-size: .95rem; font-weight: 700; color: #fff !important; margin: 0; }
.emp-card-dark .emp-card-body  { padding: 18px 22px; }
.emp-link { font-size: .82rem; font-weight: 600; color: #f5d06f !important; text-decoration: none; }

/* ── Stat cards dark ── */
.emp-stat-dark {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 18px; padding: 20px;
    display: flex; align-items: center; gap: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,.15);
    transition: transform .2s;
}
.emp-stat-dark:hover { transform: translateY(-3px); }
.emp-stat-dark .emp-stat-icon {
    width: 52px; height: 52px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.emp-stat-dark .emp-stat-num { font-size: 1.7rem; font-weight: 800; color: #fff !important; line-height: 1; }
.emp-stat-dark .emp-stat-lbl { font-size: .82rem; font-weight: 600; color: rgba(255,255,255,.7) !important; margin-top: 2px; }
.emp-stat-dark .emp-stat-sub { font-size: .75rem; color: rgba(255,255,255,.4) !important; }

/* ── Plan rows dark ── */
.emp-plan-dark {
    display: flex; justify-content: space-between; align-items: center;
    gap: 12px; padding: 14px 22px;
    border-bottom: 1px solid rgba(255,255,255,.05);
    transition: background .15s;
}
.emp-plan-dark:last-child { border-bottom: none; }
.emp-plan-dark:hover { background: rgba(255,255,255,.02); }
.emp-icon-box-dark {
    width: 42px; height: 42px; border-radius: 12px;
    background: rgba(212,175,55,.12);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.emp-badge-dark {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(212,175,55,.12); color: #f5d06f !important;
    font-size: .75rem; font-weight: 700;
    padding: 4px 12px; border-radius: 999px; border: 1px solid rgba(212,175,55,.2);
}
.emp-quick-dark {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 8px; padding: 18px 12px;
    background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 16px;
    text-decoration: none; transition: .2s;
}
.emp-quick-dark:hover {
    background: rgba(212,175,55,.1); border-color: rgba(212,175,55,.25);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(212,175,55,.12);
}
.emp-quick-dark span { font-size: .8rem; font-weight: 600; color: rgba(255,255,255,.7) !important; }
.emp-empty-dark { text-align: center; padding: 28px 16px; color: rgba(255,255,255,.35) !important; }
.emp-empty-dark i { font-size: 1.8rem; opacity: .4; display: block; margin-bottom: 8px; }
.emp-avail-dark {
    background: rgba(212,175,55,.06);
    border: 1px solid rgba(212,175,55,.15);
    border-radius: 14px; padding: 14px;
}

/* ── Topbar salon image ── */
.topbar-salon-img {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid rgba(212,175,55,.5);
    box-shadow: 0 0 0 3px rgba(212,175,55,.12), 0 4px 14px rgba(0,0,0,.35);
    flex-shrink: 0;
    margin-left: auto;
    transition: transform .3s, box-shadow .3s;
}
.topbar-salon-img:hover {
    transform: scale(1.07);
    box-shadow: 0 0 0 4px rgba(212,175,55,.3), 0 6px 20px rgba(0,0,0,.45);
}
@media(max-width:640px) {
    .topbar-salon-img { width: 40px; height: 40px; }
}

/* ── Planning nav link — icône distincte ── */
.nav-link-planning i {
    color: #ffffff !important;
    filter: none;
}
.nav-link-planning:not(.active) {
    border-left: 2.5px solid rgba(139,92,246,.4);
    padding-left: 11px;
}
.nav-link-planning:not(.active):hover {
    border-left-color: #8b5cf6;
}

/* ── Scrollbar ── */
::-webkit-scrollbar-track { background: #08101f; }
::-webkit-scrollbar-thumb { background: rgba(212,175,55,.25); border-radius: 20px; }

/* ── Mobile burger ── */
.mob-burger-btn {
    display: none;
    background: rgba(139,92,246,.12);
    border: 1px solid rgba(139,92,246,.3);
    border-radius: 12px;
    width: 42px; height: 42px;
    align-items: center; justify-content: center;
    cursor: pointer;
    color: #c4b5fd; font-size: 20px;
    transition: background .2s; flex-shrink: 0;
}
.mob-burger-btn:hover { background: rgba(139,92,246,.22); }

/* ── Responsive ── */
@media (max-width: 1180px) {
    .sidebar { width: 260px; }
    .content { margin-left: 260px; }
}

@media (max-width: 980px) {
    .sidebar         { display: none; }
    .content         { margin-left: 0; padding: 20px; padding-bottom: 90px; }
    .mob-topbar      { display: flex; }
    .drawer-overlay  { display: block; pointer-events: none; }
    .bottom-nav      { display: flex; }
    .mob-burger-btn  { display: flex; }
    .topbar          { flex-wrap: wrap; padding: 14px 16px; gap: 10px; }
    .topbar-actions  { width: 100%; justify-content: space-between; flex-wrap: wrap; }
}

@media (max-width: 640px) {
    .content          { padding: 12px; padding-bottom: 90px; }
    .bnav-item        { font-size: .55rem; min-width: 44px; padding: 6px 6px; }
    .topbar           { padding: 11px 12px; gap: 8px; border-radius: 16px; }
    .profile-card     { padding: 6px 8px; gap: 8px; }
    .profile-card img { width: 34px; height: 34px; }
    .profile-card .profile-meta { display: none; }
    /* Responsive grids */
    .row.g-4 > [class*="col-md"],
    .row.g-3 > [class*="col-md"],
    .row.g-2 > [class*="col-md"] { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }
    /* Responsive images */
    .content img:not(.profile-avatar) { max-width: 100%; height: auto; }
}

/* ── Responsive tables ── */
.content .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
@media (max-width: 640px) {
    .admin-card { overflow-x: auto; }
}

/* ══ GREEN SPINNER ══ */
@keyframes spin-green { to { transform: rotate(360deg); } }
.btn-spinner {
    display: inline-block;
    width: 16px; height: 16px;
    border: 2.5px solid rgba(34,197,94,.2);
    border-top-color:   #22c55e;
    border-right-color: #22c55e;
    border-radius: 50%;
    animation: spin-green .6s linear infinite;
    vertical-align: middle;
    margin-right: 6px;
    flex-shrink: 0;
}
.btn-submitting {
    opacity: .78 !important;
    pointer-events: none !important;
    cursor: not-allowed !important;
}
</style>

    @stack('styles')
</head>

<body>

{{-- SHARED NAVBAR --}}
@include('partials.main-navbar')

{{-- DRAWER OVERLAY --}}
<div class="drawer-overlay" id="drawer-overlay" onclick="toggleDrawer()"></div>

{{-- MOBILE DRAWER --}}
<div class="mobile-drawer" id="mobile-drawer" role="navigation" aria-label="{{ __('messages.navigation') }}">

    <div class="drawer-user-card">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'E') }}&background=111827&color=d4af37&bold=true"
             alt="{{ auth()->user()->name ?? 'Employé' }}"
             class="drawer-user-avatar">
        <div>
            <div class="drawer-user-name">{{ auth()->user()->name ?? 'Employé' }}</div>
            <div class="drawer-user-role">{{ __('messages.role_employee') }}</div>
        </div>
    </div>

    <div class="drawer-scroll">
        <div class="drawer-section-label">{{ __('messages.navigation') }}</div>

        <a href="{{ route('home') }}" class="drawer-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> {{ __('messages.home') }}
        </a>
        <a href="{{ route('employee.dashboard') }}" class="drawer-nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}
        </a>

        <div class="drawer-section-label">{{ __('messages.my_space') }}</div>

        <a href="{{ route('employee.reservations') }}" class="drawer-nav-link {{ request()->routeIs('employee.reservations*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> {{ __('messages.reservations') }}
        </a>
        <a href="{{ route('employee.planning') }}" class="drawer-nav-link {{ request()->routeIs('employee.planning*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-days"></i> {{ __('messages.planning') }}
        </a>
        <a href="{{ route('employee.availability') }}" class="drawer-nav-link {{ request()->routeIs('employee.availability') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> {{ __('messages.availability') }}
        </a>

        <div class="drawer-section-label">{{ __('messages.section_salon') }}</div>

        <a href="{{ route('employee.salons') }}" class="drawer-nav-link {{ request()->routeIs('employee.salons*') ? 'active' : '' }}">
            <i class="bi bi-shop"></i> {{ __('messages.my_salon') }}
        </a>
        <a href="{{ route('employee.services') }}" class="drawer-nav-link {{ request()->routeIs('employee.services*') ? 'active' : '' }}">
            <i class="bi bi-scissors"></i> {{ __('messages.services') }}
        </a>

        <div class="drawer-section-label">{{ __('messages.account') }}</div>

        <a href="{{ route('employee.profile') }}" class="drawer-nav-link {{ request()->routeIs('employee.profile*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> {{ __('messages.my_profile') }}
        </a>

        <div class="drawer-lang-pills">
            <a href="{{ route('locale.switch', 'fr') }}"
               class="drawer-lang-pill {{ app()->getLocale() === 'fr' ? 'active' : '' }}">
                FR
            </a>
            <a href="{{ route('locale.switch', 'en') }}"
               class="drawer-lang-pill {{ app()->getLocale() === 'en' ? 'active' : '' }}">
                EN
            </a>
            <a href="{{ route('locale.switch', 'es') }}"
               class="drawer-lang-pill {{ app()->getLocale() === 'es' ? 'active' : '' }}">
                ES
            </a>
        </div>

        <div style="height:8px;"></div>
    </div>

    <div class="drawer-foot">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn-emp-logout w-100 d-flex align-items-center justify-content-center gap-2" type="submit">
                <i class="bi bi-box-arrow-right"></i> {{ __('messages.logout') }}
            </button>
        </form>
    </div>

</div>

{{-- SIDEBAR DESKTOP --}}
<div class="sidebar">

    <div class="sidebar-profile-card">
        <div class="sidebar-profile-inner">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'E') }}&background=111827&color=d4af37&bold=true"
                 alt="{{ auth()->user()->name ?? 'Employé' }}"
                 class="sidebar-profile-avatar">
            <div style="min-width:0;">
                <div class="sidebar-profile-name">{{ auth()->user()->name ?? 'Employé' }}</div>
                <div class="sidebar-profile-badge">
                    <i class="bi bi-person-fill"></i>
                    {{ __('messages.role_employee') }}
                </div>
            </div>
        </div>
    </div>

    <div class="sidebar-nav">
        <div class="menu-title">{{ __('messages.navigation') }}</div>
        <div class="nav-section">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> {{ __('messages.home') }}
            </a>
            <a href="{{ route('employee.dashboard') }}" class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}
            </a>
        </div>

        <div class="menu-title" style="margin-top:8px;">{{ __('messages.my_space') }}</div>
        <div class="nav-section">
            <a href="{{ route('employee.reservations') }}" class="nav-link {{ request()->routeIs('employee.reservations*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> {{ __('messages.reservations') }}
            </a>
            <a href="{{ route('employee.planning') }}" class="nav-link nav-link-planning {{ request()->routeIs('employee.planning*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i> {{ __('messages.planning') }}
            </a>
            <a href="{{ route('employee.availability') }}" class="nav-link {{ request()->routeIs('employee.availability') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> {{ __('messages.availability') }}
            </a>
        </div>

        <div class="menu-title" style="margin-top:8px;">{{ __('messages.section_salon') }}</div>
        <div class="nav-section">
            <a href="{{ route('employee.salons') }}" class="nav-link {{ request()->routeIs('employee.salons*') ? 'active' : '' }}">
                <i class="bi bi-shop"></i> {{ __('messages.my_salon') }}
            </a>
            <a href="{{ route('employee.services') }}" class="nav-link {{ request()->routeIs('employee.services*') ? 'active' : '' }}">
                <i class="bi bi-scissors"></i> {{ __('messages.services') }}
            </a>
        </div>

        <div class="menu-title" style="margin-top:8px;">{{ __('messages.account') }}</div>
        <div class="nav-section">
            <a href="{{ route('employee.profile') }}" class="nav-link {{ request()->routeIs('employee.profile*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> {{ __('messages.my_profile') }}
            </a>
        </div>
    </div>

    <div class="sidebar-footer">

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn-emp-logout" type="submit">
                <i class="bi bi-box-arrow-right"></i>
                {{ __('messages.logout') }}
            </button>
        </form>

    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="content">

    <div class="topbar">
       
        </button>

        <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair" class="topbar-salon-img">
    </div>

    @include('partials.promo-banner')

    @yield('content')

</div>

{{-- BOTTOM NAV (mobile) --}}
<nav class="bottom-nav">
    <a href="{{ route('employee.dashboard') }}" class="bnav-item {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        {{ __('messages.dashboard') }}
    </a>
    <a href="{{ route('employee.reservations') }}" class="bnav-item {{ request()->routeIs('employee.reservations*') ? 'active' : '' }}">
        <i class="bi bi-calendar-check"></i>
        {{ __('messages.reservations') }}
    </a>
    <a href="{{ route('employee.planning') }}" class="bnav-item {{ request()->routeIs('employee.planning*') ? 'active' : '' }}">
        <i class="fa-solid fa-calendar-days"></i>
        {{ __('messages.planning') }}
    </a>
    <a href="{{ route('employee.availability') }}" class="bnav-item {{ request()->routeIs('employee.availability') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i>
        {{ __('messages.availability') }}
    </a>
    <a href="{{ route('employee.profile') }}" class="bnav-item {{ request()->routeIs('employee.profile*') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i>
        {{ __('messages.profile') }}
    </a>
</nav>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function openDrawer() {
        document.getElementById('mobile-drawer').classList.add('open');
        document.getElementById('drawer-overlay').classList.add('visible');
        document.body.style.overflow = 'hidden';
    }
    function closeDrawer() {
        document.getElementById('mobile-drawer').classList.remove('open');
        document.getElementById('drawer-overlay').classList.remove('visible');
        document.body.style.overflow = '';
    }
    function toggleDrawer() {
        document.getElementById('mobile-drawer').classList.contains('open') ? closeDrawer() : openDrawer();
    }
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.drawer-nav-link').forEach(link => {
            link.addEventListener('click', () => closeDrawer());
        });
    });
    window.addEventListener('resize', () => { if (window.innerWidth > 980) closeDrawer(); });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && document.getElementById('mobile-drawer').classList.contains('open')) closeDrawer();
    });
</script>

@stack('scripts')

<script>
/* ── Green spinner on form submit ── */
(function () {
    function attachSpinner(form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('[type="submit"]:not([data-no-loading])');
            if (!btn || btn.disabled) return;
            var sp = document.createElement('span');
            sp.className = 'btn-spinner';
            btn.insertBefore(sp, btn.firstChild);
            btn.classList.add('btn-submitting');
            btn.disabled = true;
        });
    }
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form').forEach(attachSpinner);
        /* Auto table scroll on mobile */
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.content table:not(.fc-scrollgrid):not(.noresponse)').forEach(function (t) {
                if (t.closest('.table-scroll') || t.closest('.table-responsive')) return;
                var w = document.createElement('div');
                w.style.cssText = 'overflow-x:auto;-webkit-overflow-scrolling:touch;width:100%;';
                t.parentNode.insertBefore(w, t);
                w.appendChild(t);
            });
        }
    });
    /* Watch for dynamically added forms */
    document.addEventListener('DOMContentLoaded', function () {
        new MutationObserver(function (muts) {
            muts.forEach(function (m) {
                m.addedNodes.forEach(function (n) {
                    if (n.nodeType !== 1) return;
                    if (n.tagName === 'FORM') attachSpinner(n);
                    n.querySelectorAll && n.querySelectorAll('form').forEach(attachSpinner);
                });
            });
        }).observe(document.body, { childList: true, subtree: true });
    });
})();
</script>

@include('partials.toast')
</body>
</html>

