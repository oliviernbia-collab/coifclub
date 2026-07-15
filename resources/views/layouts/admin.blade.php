<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.admin_title'))</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    --primary: #D4AF37;
    --primary-lt: #f6e27a;
    --accent: #f6e27a;
    --radius: 22px;
    --shadow: 0 20px 50px rgba(0,0,0,0.18);
}

* { box-sizing: border-box; }

body {
    margin: 0;
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
    background: radial-gradient(circle at top, rgba(212,175,55,0.08), transparent 30%),
                linear-gradient(180deg, #08101f 0%, #05070f 100%);
    color: var(--text);
    overflow-x: hidden;
}

a { color: inherit; text-decoration: none; }

.sidebar {
    width: 290px;
    position: fixed;
    top: 78px; left: 0; bottom: 0;
    padding: 28px 20px;
    background: linear-gradient(180deg, #0f172a 0%, #111827 100%);
    border-right: 1px solid rgba(148,163,184,0.15);
    display: flex;
    flex-direction: column;
    gap: 24px;
    overflow-y: auto;
    z-index: 50;
}

.sidebar .brand {
    display: flex;
    gap: 14px;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 18px;
}

.sidebar .brand img {
    width: 46px;
    height: 46px;
    border-radius: 14px;
    object-fit: cover;
    border: 1px solid rgba(255,255,255,0.12);
}

.sidebar .brand-title    { line-height: 1.1; font-size: 1rem; font-weight: 700; }
.sidebar .brand-subtitle { font-size: 0.8rem; color: var(--muted); }

.sidebar .menu-title {
    text-transform: uppercase;
    letter-spacing: 0.18em;
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--muted);
    margin: 0 0 10px;
}

.sidebar .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 16px;
    color: rgba(241,245,249,0.88);
    transition: all 0.25s ease;
    font-weight: 500;
}

.sidebar .nav-link i { width: 22px; text-align: center; font-size: 1.1rem; }

.sidebar .nav-link:hover {
    transform: translateX(4px);
    color: white;
    background: rgba(212,175,55,0.12);
}

.sidebar .nav-link.active {
    color: #111827;
    background: linear-gradient(135deg, #D4AF37, #f6e27a);
    box-shadow: 0 18px 35px rgba(212,175,55,0.25);
}

.sidebar .nav-section { display: flex; flex-direction: column; gap: 6px; }
.sidebar .sidebar-footer { margin-top: auto; }

.content {
    margin-left: 290px;
    padding: 32px;
    min-height: 100vh;
}

.topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding: 22px 26px;
    border-radius: var(--radius);
    background: rgba(15,23,42,0.95);
    border: 1px solid rgba(148,163,184,0.12);
    box-shadow: var(--shadow);
    margin-bottom: 26px;
    backdrop-filter: blur(12px);
}

.topbar h1 { margin: 0; font-size: 1.35rem; letter-spacing: -0.03em; }
.topbar small { color: var(--muted); }

.profile-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 16px;
    border-radius: 16px;
    border: 1px solid rgba(148,163,184,0.12);
    background: rgba(255,255,255,0.04);
}

.profile-card img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid rgba(255,255,255,0.12);
}

.profile-card .profile-meta { display: flex; flex-direction: column; gap: 2px; }
.profile-card .profile-meta strong { font-size: 0.95rem; }
.profile-card .profile-meta span  { color: var(--muted); font-size: 0.82rem; }

.page-title    { font-size: 1.3rem; margin: 0; font-weight: 700; }
.page-subtitle { color: var(--muted); font-size: 0.95rem; }

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

.flex-between { display: flex; justify-content: space-between; align-items: center; }
.flex-center   { display: flex; align-items: center; }

@media (max-width: 980px) {
    .grid-2, .grid-3 { grid-template-columns: 1fr; }
}

.admin-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 22px;
}

.admin-card {
    grid-column: span 12;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(148,163,184,0.12);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 26px;
}

.admin-card.small { grid-column: span 6; }
.admin-card h3 { margin-top: 0; margin-bottom: 18px; font-size: 1.05rem; letter-spacing: -0.02em; }

.admin-card .badge-soft {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    border-radius: 999px;
    background: rgba(255,255,255,0.07);
    color: var(--muted);
    font-size: 0.8rem;
    font-weight: 600;
}

.admin-card table { width: 100%; border-collapse: collapse; color: var(--text); }

.admin-card table th,
.admin-card table td {
    padding: 14px 12px;
    border-bottom: 1px solid rgba(148,163,184,0.1);
    vertical-align: middle;
}

.admin-card table th {
    color: var(--muted);
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

.admin-card table tbody tr:hover { background: rgba(255,255,255,0.03); }

.btn-admin {
    background: linear-gradient(135deg, #D4AF37, #f6e27a);
    border: none;
    color: #111827;
    border-radius: 14px;
    padding: 11px 20px;
    font-weight: 700;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-admin:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 35px rgba(212,175,55,0.30);
}

.text-muted { color: var(--muted) !important; }

.mob-topbar {
    display: none;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    background: #0f172a;
    border-bottom: 1px solid rgba(148,163,184,0.12);
    position: sticky;
    top: 0;
    z-index: 100;
}

.mob-logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.mob-logo img {
    width: 90px;
    height: 32px;
    object-fit: contain;
    border: 1px solid rgba(255,255,255,0.1);
}

.mob-logo-name { font-size: 14px; font-weight: 700; color: var(--text); line-height: 1.1; }
.mob-logo-sub  { font-size: 10px; color: var(--muted); }

.burger-btn {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(148,163,184,0.15);
    border-radius: 10px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background .2s;
    color: var(--text);
    font-size: 18px;
    flex-shrink: 0;
}

.burger-btn:hover { background: rgba(212,175,55,0.14); }

/* Trouvez cette règle dans votre CSS et modifiez-la : */
.drawer-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    z-index: 200;
    opacity: 0;
    transition: opacity .3s;
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
    pointer-events: none; /* ← AJOUTEZ CECI */
}

.drawer-overlay.visible {
    opacity: 1;
    pointer-events: auto; /* ← AJOUTEZ CECI */
}

/* Et dans le media query 980px, changez : */
@media (max-width: 980px) {
    .sidebar       { display: none; }
    .content       { margin-left: 0; padding: 20px; }
    .mob-topbar    { display: flex; }
    .drawer-overlay { display: block; pointer-events: none; } /* ← pointer-events: none ici aussi */
    .admin-grid { grid-template-columns: 1fr; }
    .admin-card.small { grid-column: span 1; }
}

.mobile-drawer {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 290px;
    background: linear-gradient(180deg, #0f172a 0%, #111827 100%);
    border-right: 1px solid rgba(148,163,184,0.12);
    z-index: 300;
    transform: translateX(-100%);
    transition: transform .35s cubic-bezier(.4,0,.2,1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.mobile-drawer.open { transform: translateX(0); }

.drawer-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 18px 14px;
    border-bottom: 1px solid rgba(148,163,184,0.1);
    flex-shrink: 0;
}

.drawer-brand { display: flex; align-items: center; gap: 10px; }

.drawer-brand img {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    object-fit: cover;
    border: 1px solid rgba(255,255,255,0.1);
}

.drawer-brand-name { font-size: 13px; font-weight: 700; color: var(--text); }
.drawer-brand-sub  { font-size: 10px; color: var(--muted); }

.drawer-close-btn {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(148,163,184,0.12);
    border-radius: 8px;
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--muted);
    font-size: 16px;
    transition: background .2s, color .2s;
    flex-shrink: 0;
}

.drawer-close-btn:hover { background: rgba(212,175,55,0.12); color: #f6e27a; }

.drawer-scroll {
    flex: 1;
    overflow-y: auto;
    padding: 12px 12px 0;
    scrollbar-width: thin;
    scrollbar-color: rgba(148,163,184,0.18) transparent;
}

.drawer-scroll::-webkit-scrollbar       { width: 4px; }
.drawer-scroll::-webkit-scrollbar-track { background: transparent; }
.drawer-scroll::-webkit-scrollbar-thumb { background: rgba(148,163,184,0.2); border-radius: 4px; }

.drawer-section-label {
    font-size: 9px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .16em;
    color: var(--muted);
    padding: 12px 8px 6px;
}

.drawer-nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 12px;
    border-radius: 13px;
    color: rgba(241,245,249,.85);
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all .2s;
    margin-bottom: 2px;
}

.drawer-nav-link i { font-size: 16px; width: 20px; text-align: center; flex-shrink: 0; }
.drawer-nav-link:hover { background: rgba(212,175,55,.1); color: #fff; transform: translateX(3px); }

.drawer-nav-link.active {
    background: linear-gradient(135deg, #D4AF37, #f6e27a);
    color: #111827;
    box-shadow: 0 8px 24px rgba(212,175,55,.25);
}

.drawer-foot {
    padding: 12px;
    border-top: 1px solid rgba(148,163,184,.1);
    flex-shrink: 0;
}

.drawer-profile-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 13px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(148,163,184,.1);
    margin-bottom: 10px;
}

.drawer-profile-row img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.drawer-profile-name { font-size: 13px; font-weight: 600; color: var(--text); }
.drawer-profile-role { font-size: 10px; color: var(--muted); }


.lang-switch-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #ffffff, #f8fafc);
    border: 1px solid rgba(0,0,0,0.08);
    padding: 8px 12px;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    transition: all 0.25s ease;
    width: fit-content;
}

.lang-switch-wrapper:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.10);
}

.lang-icon {
    font-size: 18px;
    background: #eef2ff;
    padding: 6px 8px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lang-switch {
    border-radius: 999px;
    padding: 10px 14px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    color: #fbbf24;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s ease, transform .2s ease;
}

.lang-switch option { padding: 10px; }

/* ── Lang pills (replaces select in topbar) ── */
.lang-pills {
    display: flex; align-items: center; gap: 4px;
    background: #f0f1ff;
    border: 1px solid #ddd6fe;
    border-radius: 30px; padding: 4px 6px;
}
.lang-pill {
    display: flex; align-items: center; gap: 5px;
    padding: 5px 10px; border-radius: 20px;
    border: none; background: transparent;
    color: #6b21a8;
    font-size: 12px; font-weight: 600;
    cursor: pointer; text-decoration: none;
    transition: background .2s, color .2s; white-space: nowrap;
}
.lang-pill .flag { font-size: 16px; line-height: 1; }
.lang-pill:hover { background: rgba(107,33,168,.1); color: #4c1d95; }
.lang-pill.active { background: linear-gradient(135deg, #e91e8c, #c0156d); color: #fff; }



@media (max-width: 1180px) {
    .sidebar { width: 260px; }
    .content { margin-left: 260px; }
}

@media (max-width: 980px) {
    .sidebar       { display: none; }
    .content       { margin-left: 0; padding: 20px; }
    .mob-topbar    { display: flex; }
    .drawer-overlay { display: block; }
    .admin-grid { grid-template-columns: 1fr; }
    .admin-card.small { grid-column: span 1; }
    .topbar { flex-wrap: wrap; gap: 10px; }
    .topbar h1 { font-size: 1.1rem; }
    .profile-card .profile-meta { display: none; }
}

@media (max-width: 640px) {
    .content { padding: 12px; }
    .admin-card { padding: 16px; overflow-x: auto; }
    .topbar { padding: 14px 16px; border-radius: 16px; }
    /* Force Bootstrap grid columns to full-width on small phones */
    .row.g-4 > [class*="col-md"],
    .row.g-3 > [class*="col-md"] { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }
}

/* ── Lang pills dans le drawer admin ── */
.drawer-lang-pills {
    display: flex; gap: 6px; padding: 10px 4px 6px;
    border-top: 1px solid rgba(255,255,255,.06); margin-top: 8px;
}
.drawer-lang-pill {
    flex: 1; text-align: center; padding: 9px 4px;
    border-radius: 10px; font-size: 13px; font-weight: 700;
    text-decoration: none; transition: .2s;
    background: rgba(255,255,255,.06); color: rgba(255,255,255,.6);
    border: 1px solid rgba(255,255,255,.08);
}
.drawer-lang-pill:hover { background: rgba(233,30,140,.15); color: #fff; }
.drawer-lang-pill.active { background: linear-gradient(135deg,#e91e8c,#c0156d); color: #fff; border-color: transparent; }

@media (max-width: 600px) {
    .content { padding: 12px; }
}

/* ── Responsive tables ── */
.table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.admin-card table { min-width: 540px; }
@media (max-width: 640px) {
    .admin-card { overflow-x: auto; }
}

/* ── Select visibility (global admin) ── */
select,
.form-select {
    background-color: #1e293b !important;
    color: #f1f5f9 !important;
    border: 1px solid rgba(255,255,255,0.15) !important;
}

select option,
.form-select option {
    background-color: #1e293b;
    color: #f1f5f9;
}

select:focus,
.form-select:focus {
    border-color: #D4AF37 !important;
    outline: none;
    box-shadow: 0 0 0 3px rgba(212,175,55,0.15) !important;
}
</style>

    @stack('styles')
<style>
/* ══════════════════════════════════════════════════════
   DARK THEME — Admin Panel (matches client design)
══════════════════════════════════════════════════════ */

/* ── Body + Root ───────────────────────────────────── */
body { background: #0e0a1c !important; color: rgba(255,255,255,.88) !important; padding-top: 78px !important; }

/* ── Root vars ─────────────────────────────────────── */
:root {
    --text: rgba(255,255,255,.88);
    --bg: #0e0a1c;
    --surface: rgba(255,255,255,.04);
    --surface-soft: rgba(255,255,255,.02);
    --muted: rgba(255,255,255,.45);
    --border-col: rgba(255,255,255,.08);
    --primary: #e91e8c;
    --primary-lt: #ff6ab4;
    --gradient: linear-gradient(135deg,#e91e8c,#c91a78);
}

/* ── Sidebar (dark purple) ─────────────────────────── */
.sidebar {
    background: #1a1230 !important;
    border-right: 1px solid rgba(233,30,140,.1) !important;
    padding: 0 !important;
    gap: 0 !important;
}
.sidebar .brand { background: rgba(255,255,255,.04) !important; border: 1px solid rgba(255,255,255,.06) !important; border-radius: 18px !important; }
.sidebar .brand-title { color: #fff !important; }
.sidebar .brand-subtitle { color: rgba(255,255,255,.45) !important; }
.sidebar-nav { flex: 1; overflow-y: auto; padding: 14px 14px 8px; scrollbar-width: thin; scrollbar-color: rgba(233,30,140,.2) transparent; }
.sidebar-nav::-webkit-scrollbar { width: 3px; }
.sidebar-nav::-webkit-scrollbar-thumb { background: rgba(233,30,140,.2); border-radius: 4px; }
.sidebar .menu-title { color: rgba(255,255,255,.22) !important; font-size: .68rem !important; }
.sidebar .nav-link { color: rgba(255,255,255,.58) !important; font-size: 13px !important; padding: 11px 14px !important; border-radius: 12px !important; }
.sidebar .nav-link:hover { color: white !important; background: rgba(255,255,255,.07) !important; transform: translateX(3px) !important; }
.sidebar .nav-link.active { color: white !important; background: linear-gradient(135deg, #e91e8c, #c0156d) !important; box-shadow: 0 4px 18px rgba(233,30,140,.3) !important; }
.sidebar-footer { padding: 10px 14px 16px; border-top: 1px solid rgba(255,255,255,.06); flex-shrink: 0; }
.sidebar-footer .btn, .sidebar-footer .btn-admin { background: rgba(239,68,68,.1) !important; border: 1px solid rgba(239,68,68,.2) !important; color: rgba(239,68,68,.8) !important; box-shadow: none !important; border-radius: 12px !important; font-size: 13px !important; font-weight: 600 !important; }
.sidebar-footer .btn:hover, .sidebar-footer .btn-admin:hover { background: rgba(239,68,68,.18) !important; color: #EF4444 !important; transform: none !important; box-shadow: none !important; }

/* ── Content area ──────────────────────────────────── */
.content { background: transparent !important; }

/* ── Topbar ────────────────────────────────────────── */
.topbar { background: rgba(14,10,28,.92) !important; border: 1px solid rgba(233,30,140,.12) !important; box-shadow: 0 4px 24px rgba(0,0,0,.3) !important; backdrop-filter: blur(20px) !important; }

/* ── Topbar salon image ── */
.topbar-salon-img {
    width: 52px; height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid rgba(233,30,140,.5);
    box-shadow: 0 0 0 3px rgba(233,30,140,.12), 0 4px 14px rgba(0,0,0,.35);
    flex-shrink: 0;
    margin-left: auto;
    transition: transform .3s, box-shadow .3s;
}
.topbar-salon-img:hover {
    transform: scale(1.07);
    box-shadow: 0 0 0 4px rgba(233,30,140,.3), 0 6px 20px rgba(0,0,0,.45);
}
@media(max-width:640px) { .topbar-salon-img { width: 40px; height: 40px; } }
.topbar h1, .page-title { color: #fff !important; -webkit-text-fill-color: #fff !important; background: none !important; }
.topbar small, .page-subtitle { color: rgba(255,255,255,.45) !important; }
.profile-card { background: rgba(255,255,255,.05) !important; border: 1px solid rgba(255,255,255,.08) !important; }
.profile-card strong, .profile-card .profile-meta strong { color: #fff !important; }
.profile-card span, .profile-card .profile-meta span { color: rgba(255,255,255,.45) !important; }

/* ── Admin cards ───────────────────────────────────── */
.admin-card { background: rgba(255,255,255,.04) !important; border: 1px solid rgba(255,255,255,.08) !important; box-shadow: 0 4px 24px rgba(0,0,0,.25) !important; }
.admin-card h3, .admin-card h4, .admin-card h5 { color: #fff !important; }
.admin-card table { color: rgba(255,255,255,.85) !important; }
.admin-card table th { color: rgba(255,255,255,.5) !important; background: rgba(233,30,140,.08) !important; }
.admin-card table td { color: rgba(255,255,255,.8) !important; border-bottom-color: rgba(255,255,255,.05) !important; }
.admin-card table tbody tr:hover { background: rgba(255,255,255,.03) !important; }
.admin-card .badge-soft { background: rgba(233,30,140,.1) !important; color: #ff6ab4 !important; border-color: rgba(233,30,140,.2) !important; }

/* ── adm-* classes (dashboard + individual pages) ─── */
.adm-card { background: rgba(255,255,255,.04) !important; border: 1px solid rgba(255,255,255,.08) !important; box-shadow: 0 4px 24px rgba(0,0,0,.25) !important; }
.adm-card-title { color: #fff !important; }
.adm-card-head { border-bottom-color: rgba(255,255,255,.06) !important; }
.adm-stat { background: rgba(255,255,255,.04) !important; border: 1px solid rgba(255,255,255,.08) !important; box-shadow: 0 4px 24px rgba(0,0,0,.2) !important; }
.adm-stat-num { color: #fff !important; -webkit-text-fill-color: #fff !important; }
.adm-stat-lbl { color: rgba(255,255,255,.65) !important; }
.adm-stat-sub { color: rgba(255,255,255,.4) !important; }
.adm-badge { background: rgba(233,30,140,.1) !important; color: #ff6ab4 !important; border-color: rgba(233,30,140,.2) !important; }
.adm-link { color: #ff6ab4 !important; }
.adm-db h1,.adm-db h2,.adm-db h3,.adm-db h4,.adm-db h5 { color: #fff !important; -webkit-text-fill-color: #fff !important; background: none !important; }
.adm-db p,.adm-db small { color: rgba(255,255,255,.5) !important; }

/* ── Content global text ───────────────────────────── */
.content h1,.content h2,.content h3,.content h4,.content h5,.content h6 { color: #fff !important; -webkit-text-fill-color: #fff !important; background: none !important; }
.content .page-title { color: #fff !important; -webkit-text-fill-color: #fff !important; background: none !important; }
.content p, .content li, .content small { color: rgba(255,255,255,.55) !important; }
.content label, .content .form-label { color: rgba(255,255,255,.7) !important; }
.content .form-control, .content .form-select { color: #fff !important; background: rgba(255,255,255,.06) !important; border-color: rgba(255,255,255,.12) !important; }
.content .form-control::placeholder { color: rgba(255,255,255,.3) !important; }
.content .input-group-text { color: rgba(255,255,255,.6) !important; background: rgba(255,255,255,.04) !important; border-color: rgba(255,255,255,.12) !important; }
.content .table, .content table { color: rgba(255,255,255,.85) !important; }
.content .table th, .content .table td { color: rgba(255,255,255,.8) !important; border-color: rgba(255,255,255,.06) !important; }
.content table thead th { color: rgba(255,255,255,.6) !important; background: rgba(233,30,140,.1) !important; border-bottom: 2px solid rgba(233,30,140,.2) !important; }
.content table td { color: rgba(255,255,255,.8) !important; border-color: rgba(255,255,255,.06) !important; }
.content table tbody tr:hover { background: rgba(255,255,255,.02) !important; }
.content .card { background: rgba(255,255,255,.04) !important; border: 1px solid rgba(255,255,255,.08) !important; }
.content .card-header, .content .card-body, .content .card-footer { background: transparent !important; color: rgba(255,255,255,.85) !important; border-color: rgba(255,255,255,.06) !important; }
.content .text-muted { color: rgba(255,255,255,.45) !important; }
.content .text-white { color: #fff !important; }
.content .text-light { color: rgba(255,255,255,.7) !important; }
.content .alert-success { color: #4ade80 !important; background: rgba(74,222,128,.1) !important; border-color: rgba(74,222,128,.2) !important; }
.content .alert-danger  { color: #f87171 !important; background: rgba(248,113,113,.08) !important; border-color: rgba(248,113,113,.2) !important; }
.content .alert-warning { color: #fbbf24 !important; background: rgba(251,191,36,.08) !important; border-color: rgba(251,191,36,.2) !important; }
.content .alert-info    { color: #93c5fd !important; background: rgba(147,197,253,.08) !important; border-color: rgba(147,197,253,.2) !important; }

/* ── Buttons ───────────────────────────────────────── */
.btn-admin { background: linear-gradient(135deg, #e91e8c, #c0156d) !important; color: white !important; border: none !important; }
.btn-admin:hover { box-shadow: 0 8px 24px rgba(233,30,140,.3) !important; color: white !important; }
.text-muted { color: rgba(255,255,255,.45) !important; }

/* ── Mobile drawer ─────────────────────────────────── */
.mobile-drawer { background: #1a1230 !important; border-right: 1px solid rgba(233,30,140,.1) !important; }
.drawer-section-label { color: rgba(255,255,255,.22) !important; }
.drawer-nav-link { color: rgba(255,255,255,.6) !important; }
.drawer-nav-link:hover { background: rgba(255,255,255,.07) !important; color: white !important; }
.drawer-nav-link.active { background: linear-gradient(135deg, #e91e8c, #c0156d) !important; color: white !important; box-shadow: 0 4px 16px rgba(233,30,140,.3) !important; }
.drawer-close-btn { color: rgba(255,255,255,.55) !important; }
.drawer-close-btn:hover { background: rgba(233,30,140,.2) !important; color: white !important; }
.drawer-profile-name { color: white !important; }
.drawer-profile-role { color: rgba(255,255,255,.4) !important; }
.drawer-profile-row { background: rgba(255,255,255,.04) !important; border-color: rgba(255,255,255,.07) !important; }

/* ── Cart link (topbar) ── */
.adm-cart {
    position: relative; width: 36px; height: 36px; border-radius: 50%;
    border: 1.5px solid rgba(255,255,255,.18); background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.65);
    display: inline-flex; align-items: center; justify-content: center;
    text-decoration: none; transition: .2s; flex-shrink: 0;
}
.adm-cart:hover { border-color: #e83e8c; color: #e83e8c; background: rgba(232,62,140,.1); }
.adm-cart-badge {
    position: absolute; top: -4px; right: -4px;
    min-width: 16px; height: 16px; border-radius: 999px;
    background: #e83e8c; color: #fff;
    font-size: 9px; font-weight: 700; line-height: 16px; text-align: center;
    padding: 0 3px; border: 2px solid #1a1a2e;
}

/* ── Lang pill dropdown (topbar) ── */
.adm-lang-wrap { position: relative; }
.adm-lang-pill {
    display: flex; align-items: center; gap: 5px;
    border: 1.5px solid rgba(255,255,255,.18); border-radius: 20px;
    padding: 5px 11px 5px 8px; font-size: 13px; font-weight: 600;
    color: rgba(255,255,255,.75); cursor: pointer; background: rgba(255,255,255,.06);
    transition: border-color .2s; user-select: none; white-space: nowrap;
}
.adm-lang-pill:hover { border-color: rgba(255,255,255,.4); }
.adm-lang-flag  { font-size: 16px; line-height: 1; }
.adm-lang-code  { font-size: 12.5px; font-weight: 700; color: rgba(255,255,255,.75); }
.adm-lang-chevron { font-size: 9px; color: rgba(255,255,255,.4); margin-left: 1px; transition: transform .2s; }
.adm-lang-wrap.open .adm-lang-chevron { transform: rotate(180deg); }
.adm-lang-drop {
    display: none; position: absolute; top: calc(100% + 6px); right: 0;
    background: #fff; border: 1px solid #e8e8e8; border-radius: 12px;
    min-width: 140px; box-shadow: 0 8px 28px rgba(0,0,0,.11);
    z-index: 9999; overflow: hidden; padding: 4px 0;
}
.adm-lang-wrap.open .adm-lang-drop { display: block; }
.adm-lang-opt {
    display: flex; align-items: center; gap: 9px; padding: 10px 16px;
    font-size: 13.5px; font-weight: 500; color: #444;
    text-decoration: none; transition: background .15s;
}
.adm-lang-opt:hover { background: rgba(232,62,140,.07); color: #e83e8c; }
.adm-lang-opt.active { color: #e83e8c; font-weight: 700; }
.adm-lang-opt-flag { font-size: 18px; }

/* ── Scrollbar ─────────────────────────────────────── */
::-webkit-scrollbar-track { background: #0e0a1c; }
::-webkit-scrollbar-thumb { background: rgba(233,30,140,.25); border-radius: 20px; }

/* ── Admin dashboard utility classes (dark overrides) ── */
.adm-row { border-bottom-color: rgba(255,255,255,.06) !important; }
.adm-row:hover { background: rgba(255,255,255,.02) !important; }
.adm-service { border-bottom-color: rgba(255,255,255,.06) !important; }
.adm-service-icon { background: rgba(233,30,140,.1) !important; }
.adm-pending { background: rgba(255,255,255,.04) !important; border-color: rgba(255,255,255,.08) !important; }
.adm-empty { color: rgba(255,255,255,.35) !important; }
.adm-status.bg-warning { background: rgba(251,191,36,.15) !important; color: #fbbf24 !important; }
.adm-status.bg-success { background: rgba(74,222,128,.15) !important; color: #4ade80 !important; }
.adm-status.bg-danger  { background: rgba(248,113,113,.15) !important; color: #f87171 !important; }
.adm-status.bg-info    { background: rgba(147,197,253,.15) !important; color: #93c5fd !important; }

/* Bootstrap badge overrides for dark */
.content .badge.bg-warning { background: rgba(251,191,36,.2) !important; color: #fbbf24 !important; }
.content .badge.bg-success { background: rgba(74,222,128,.15) !important; color: #4ade80 !important; }
.content .badge.bg-danger  { background: rgba(248,113,113,.15) !important; color: #f87171 !important; }
.content .badge.bg-info    { background: rgba(147,197,253,.15) !important; color: #93c5fd !important; }
.content .badge.bg-primary { background: rgba(233,30,140,.2) !important; color: #ff6ab4 !important; }
.content .badge.bg-secondary { background: rgba(255,255,255,.1) !important; color: rgba(255,255,255,.6) !important; }

/* Bootstrap form overrides for dark */
.content .form-check-label { color: rgba(255,255,255,.7) !important; }
.content .form-text { color: rgba(255,255,255,.4) !important; }
.content hr { border-color: rgba(255,255,255,.08) !important; }
.content .list-group-item { background: rgba(255,255,255,.04) !important; border-color: rgba(255,255,255,.08) !important; color: rgba(255,255,255,.85) !important; }
.content .modal-content { background: #1a1230 !important; border: 1px solid rgba(255,255,255,.1) !important; }
.content .modal-header { border-bottom-color: rgba(255,255,255,.08) !important; }
.content .modal-footer { border-top-color: rgba(255,255,255,.08) !important; }
.content .modal-title { color: #fff !important; }
</style>
</head>

<body>

{{-- ═══════════════════════════════════════
     SHARED NAVBAR (homepage design)
════════════════════════════════════════ --}}
@include('partials.main-navbar')

{{-- ═══════════════════════════════════════
     MOBILE TOPBAR (hidden — replaced by shared navbar)
════════════════════════════════════════ --}}
<div class="mob-topbar" style="display:none!important">
    <a href="{{ route('admin.dashboard') }}" class="mob-logo">
        <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair">
        <div>
            <div class="mob-logo-name">Marol Hair</div>
            <div class="mob-logo-sub">Admin Control</div>
        </div>
    </a>
    <button class="burger-btn" onclick="toggleDrawer()" aria-label="Ouvrir le menu">
        <i class="bi bi-list" id="burger-icon"></i>
    </button>
</div>

{{-- ═══════════════════════════════════════
     DRAWER OVERLAY
════════════════════════════════════════ --}}
<div class="drawer-overlay" id="drawer-overlay" onclick="toggleDrawer()"></div>

{{-- ═══════════════════════════════════════
     MOBILE DRAWER
════════════════════════════════════════ --}}
<div class="mobile-drawer" id="mobile-drawer" role="navigation" aria-label="Menu principal">

    <div class="drawer-head">
        <div class="drawer-brand">
            <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair">
            <div>
                <div class="drawer-brand-name">Marol Hair</div>
                <div class="drawer-brand-sub">{{ __('messages.admin_control') }}</div>
            </div>
        </div>
        <button class="drawer-close-btn" onclick="toggleDrawer()" aria-label="Fermer le menu">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="drawer-scroll">
        <div class="drawer-section-label">{{ __('messages.global_management') }}</div>

        <a href="{{ route('home') }}"
           class="drawer-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> {{ __('messages.home') }}
        </a>
        <a href="{{ route('admin.dashboard') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> {{ __('messages.users') }}
        </a>
        <a href="{{ route('admin.employees.index') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.employees.index') ? 'active' : '' }}">
            <i class="bi bi-person-fill"></i> {{ __('messages.employees') }}
        </a>
        <a href="{{ route('admin.salons') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.salons') ? 'active' : '' }}">
            <i class="bi bi-shop"></i> {{ __('messages.salons') }}
        </a>
        <a href="{{ route('admin.services.index') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.services.index') ? 'active' : '' }}">
            <i class="bi bi-scissors"></i> {{ __('messages.services') }}
        </a>
        <a href="{{ route('admin.categories') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> {{ __('messages.categories') }}
        </a>
        <a href="{{ route('admin.reservations') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.reservations') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> {{ __('messages.reservations') }}
        </a>
        <a href="{{ route('admin.payments') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.payments') ? 'active' : '' }}">
            <i class="bi bi-credit-card-2-front"></i> {{ __('messages.payments') }}
        </a>
        <a href="{{ route('admin.cancellations.index') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.cancellations.index') ? 'active' : '' }}">
            <i class="bi bi-arrow-counterclockwise"></i> {{ __('messages.refunds') }}
        </a>
        <a href="{{ route('admin.promotions.index') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.promotions.index') ? 'active' : '' }}">
            <i class="bi bi-gift"></i> {{ __('messages.promotions') }}
        </a>
        <a href="{{ route('admin.cancellation-policies.manage') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.cancellation-policies.manage') ? 'active' : '' }}">
            <i class="bi bi-shield-check"></i> {{ __('messages.cancellation_policy') }}
        </a>
        <a href="{{ route('admin.clients') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.clients') ? 'active' : '' }}">
            <i class="bi bi-people"></i> {{ __('messages.clients') }}
        </a>
        <a href="{{ route('admin.contacts') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i> {{ __('messages.contacts') }}
        </a>
        @php $drawerAdminUnread = auth()->user()->unreadNotifications()->count(); @endphp
        <a href="{{ route('admin.notifications') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.notifications') ? 'active' : '' }}"
           style="display:flex;align-items:center;gap:6px;">
            <i class="bi bi-bell"></i>
            <span style="flex:1;">{{ __('messages.adm_notif_title') }}</span>
            @if($drawerAdminUnread > 0)
            <span style="background:var(--primary);color:#fff;font-size:10px;font-weight:800;min-width:20px;height:20px;border-radius:10px;display:flex;align-items:center;justify-content:center;padding:0 5px;">{{ $drawerAdminUnread > 99 ? '99+' : $drawerAdminUnread }}</span>
            @endif
        </a>

        <div class="drawer-section-label">{{ __('messages.salon_tools') }}</div>

        <a href="{{ route('admin.calendar') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.calendar') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> {{ __('messages.calendar') }}
        </a>
        <a href="{{ route('admin.infoSalon') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.infoSalon') ? 'active' : '' }}">
            <i class="bi bi-shop-window"></i> {{ __('messages.salon_info') }}
        </a>
        <a href="{{ route('admin.heuresOuverture') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.heuresOuverture') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> {{ __('messages.hours') }}
        </a>
        <a href="{{ route('admin.inventaire') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.inventaire') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> {{ __('messages.inventory') }}
        </a>
        <a href="{{ route('admin.personnalisation') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.personnalisation') ? 'active' : '' }}">
            <i class="bi bi-palette"></i> {{ __('messages.customization') }}
        </a>
        <a href="{{ route('admin.rapports') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.rapports') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> {{ __('messages.reports') }}
        </a>
        <a href="{{ route('admin.logs') }}"
           class="drawer-nav-link {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> {{ __('messages.activity_log') }}
        </a>

        <div class="drawer-lang-pills">
            <a href="{{ route('locale.switch', 'fr') }}"
               class="drawer-lang-pill {{ app()->getLocale() === 'fr' ? 'active' : '' }}">FR</a>
            <a href="{{ route('locale.switch', 'en') }}"
               class="drawer-lang-pill {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            <a href="{{ route('locale.switch', 'es') }}"
               class="drawer-lang-pill {{ app()->getLocale() === 'es' ? 'active' : '' }}">ES</a>
        </div>

        <div style="height:12px;"></div>
    </div>

    <div class="drawer-foot">
        <div class="drawer-profile-row">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? __('messages.admin')) }}&background=1a1400&color=D4AF37"
                 alt="Avatar">
            <div>
                <div class="drawer-profile-name">{{ auth()->user()->name ?? __('messages.admin') }}</div>
                <div class="drawer-profile-role">{{ __('messages.super_admin') }}</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-admin w-100 d-flex align-items-center justify-content-center gap-2" type="submit">
                <i class="bi bi-box-arrow-right"></i> {{ __('messages.logout') }}
            </button>
        </form>
    </div>

</div>

{{-- ═══════════════════════════════════════
     SIDEBAR DESKTOP (visible > 980px)
════════════════════════════════════════ --}}
<div class="sidebar">

  
    <div class="sidebar-nav">
        <div class="menu-title">{{ __('messages.global_management') }}</div>

        <div class="nav-section">
            <a href="{{ route('home') }}"
               class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> {{ __('messages.home') }}
            </a>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> {{ __('messages.dashboard') }}
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> {{ __('messages.users') }}
            </a>
            <a href="{{ route('admin.employees.index') }}"
               class="nav-link {{ request()->routeIs('admin.employees.index') ? 'active' : '' }}">
                <i class="bi bi-person-fill"></i> {{ __('messages.employees') }}
            </a>
            <a href="{{ route('admin.salons') }}"
               class="nav-link {{ request()->routeIs('admin.salons') ? 'active' : '' }}">
                <i class="bi bi-shop"></i> {{ __('messages.salons') }}
            </a>
            <a href="{{ route('admin.services.index') }}"
               class="nav-link {{ request()->routeIs('admin.services.index') ? 'active' : '' }}">
                <i class="bi bi-scissors"></i> {{ __('messages.services') }}
            </a>
            
            <a href="{{ route('admin.categories') }}"
            class="nav-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> {{ __('messages.categories') }}
            </a>
            <a href="{{ route('admin.reservations') }}"
               class="nav-link {{ request()->routeIs('admin.reservations') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> {{ __('messages.reservations') }}
            </a>
            <a href="{{ route('admin.payments') }}"
               class="nav-link {{ request()->routeIs('admin.payments') ? 'active' : '' }}">
                <i class="bi bi-credit-card-2-front"></i> {{ __('messages.payments') }}
            </a>
            <a href="{{ route('admin.cancellations.index') }}"
               class="nav-link {{ request()->routeIs('admin.cancellations.index') ? 'active' : '' }}">
                <i class="bi bi-arrow-counterclockwise"></i> {{ __('messages.refunds') }}
            </a>
            <a href="{{ route('admin.promotions.index') }}"
               class="nav-link {{ request()->routeIs('admin.promotions.index') ? 'active' : '' }}">
                <i class="bi bi-gift"></i> {{ __('messages.promotions') }}
            </a>
            <a href="{{ route('admin.cancellation-policies.manage') }}"
               class="nav-link {{ request()->routeIs('admin.cancellation-policies.manage') ? 'active' : '' }}">
                <i class="bi bi-shield-check"></i> {{ __('messages.cancellation_policy') }}
            </a>
            <a href="{{ route('admin.clients') }}"
               class="nav-link {{ request()->routeIs('admin.clients') ? 'active' : '' }}">
                <i class="bi bi-people"></i> {{ __('messages.clients') }}
            </a>
            <a href="{{ route('admin.vip.index') }}"
               class="nav-link {{ request()->routeIs('admin.vip.*') ? 'active' : '' }}">
                <i class="bi bi-star-fill"></i> {{ __('messages.vip_subscriptions') }}
            </a>
            <a href="{{ route('admin.contacts') }}"
               class="nav-link {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i> {{ __('messages.contacts') }}
            </a>
            @php $sidebarUnread = auth()->user()->unreadNotifications()->count(); @endphp
            <a href="{{ route('admin.notifications') }}"
               class="nav-link {{ request()->routeIs('admin.notifications') ? 'active' : '' }}"
               style="display:flex;align-items:center;gap:6px;">
                <span style="display:inline-flex;align-items:center;gap:6px;flex:1;">
                    <i class="bi bi-bell"></i> {{ __('messages.adm_notif_title') }}
                </span>
                @if($sidebarUnread > 0)
                <span style="background:var(--primary);color:#fff;font-size:10px;font-weight:800;min-width:20px;height:20px;border-radius:10px;display:flex;align-items:center;justify-content:center;padding:0 5px;">{{ $sidebarUnread > 99 ? '99+' : $sidebarUnread }}</span>
                @endif
            </a>
        </div>

        <div class="menu-title" style="margin-top:8px;">{{ __('messages.salon_tools') }}</div>

        <div class="nav-section">
            <a href="{{ route('admin.calendar') }}"
               class="nav-link {{ request()->routeIs('admin.calendar') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> {{ __('messages.calendar') }}
            </a>
            <a href="{{ route('admin.infoSalon') }}"
               class="nav-link {{ request()->routeIs('admin.infoSalon') ? 'active' : '' }}">
                <i class="bi bi-shop-window"></i> {{ __('messages.salon_info') }}
            </a>
            <a href="{{ route('admin.heuresOuverture') }}"
               class="nav-link {{ request()->routeIs('admin.heuresOuverture') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> {{ __('messages.hours') }}
            </a>
            <a href="{{ route('admin.inventaire') }}"
               class="nav-link {{ request()->routeIs('admin.inventaire') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> {{ __('messages.inventory') }}
            </a>
            <a href="{{ route('admin.personnalisation') }}"
               class="nav-link {{ request()->routeIs('admin.personnalisation') ? 'active' : '' }}">
                <i class="bi bi-palette"></i> {{ __('messages.customization') }}
            </a>
            <a href="{{ route('admin.rapports') }}"
               class="nav-link {{ request()->routeIs('admin.rapports') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i> {{ __('messages.reports') }}
            </a>
            <a href="{{ route('admin.logs') }}"
               class="nav-link {{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> {{ __('messages.activity_log') }}
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-admin w-100 d-flex align-items-center justify-content-center gap-2" type="submit">
                <i class="bi bi-box-arrow-right"></i> {{ __('messages.logout') }}
            </button>
        </form>
    </div>

</div>

{{-- ═══════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════ --}}
<div class="content">

    <div class="topbar">
        {{-- <div>
            <h1 class="page-title">@yield('page-title', __('messages.dashboard'))</h1>
            <p class="page-subtitle mb-0">@yield('page-subtitle', __('messages.admin_control_panel'))</p>
        </div> --}}

        <div class="topbar-actions">

            @php $adminUnread = auth()->user()->unreadNotifications()->count(); @endphp
            <a href="{{ route('admin.notifications') }}"
               title="{{ __('messages.adm_notif_title') }}"
               style="position:relative;display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:12px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.7);font-size:1rem;text-decoration:none;transition:.2s;"
               onmouseover="this.style.background='rgba(212,175,55,.15)';this.style.color='#fff'"
               onmouseout="this.style.background='rgba(255,255,255,.06)';this.style.color='rgba(255,255,255,.7)'">
                <i class="fa-regular fa-bell"></i>
                @if($adminUnread > 0)
                <span style="position:absolute;top:-5px;right:-5px;background:#e91e8c;color:#fff;font-size:10px;font-weight:800;min-width:18px;height:18px;border-radius:9px;display:flex;align-items:center;justify-content:center;padding:0 4px;">{{ $adminUnread > 99 ? '99+' : $adminUnread }}</span>
                @endif
            </a>

            <a href="{{ route('admin.dashboard') }}" class="profile-card">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=1a1400&color=D4AF37"
                    alt="Avatar">
                <div class="profile-meta">
                    <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
                </div>
            </a>
        </div>

        <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair" class="topbar-salon-img">
    </div>

    @yield('content')

</div>

{{-- ═══════════════════════════════════════
     SCRIPTS
════════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function openDrawer() {
        document.getElementById('mobile-drawer').classList.add('open');
        document.getElementById('drawer-overlay').classList.add('visible');
        document.getElementById('burger-icon').className = 'bi bi-x-lg';
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        document.getElementById('mobile-drawer').classList.remove('open');
        document.getElementById('drawer-overlay').classList.remove('visible');
        document.getElementById('burger-icon').className = 'bi bi-list';
        document.body.style.overflow = '';
    }

    function toggleDrawer() {
        const isOpen = document.getElementById('mobile-drawer').classList.contains('open');
        isOpen ? closeDrawer() : openDrawer();
    }

    // ── Fermeture auto quand on clique un lien du drawer ──────────────────
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.drawer-nav-link').forEach(link => {
            link.addEventListener('click', () => {
                // Laisse la navigation se faire, puis ferme le drawer
                closeDrawer();
            });
        });

        // ── Empêche les actions topbar d'ouvrir accidentellement le drawer ──
        const topbarActions = document.querySelector('.topbar-actions');
        if (topbarActions) {
            topbarActions.addEventListener('click', e => e.stopPropagation());
        }

        const profileCard = document.querySelector('.profile-card');
        if (profileCard) {
            profileCard.addEventListener('click', e => e.stopPropagation());
        }

        // ── Select de langue : navigation directe sans déclencher le drawer ──
        const langSwitch = document.querySelector('.lang-switch');
        if (langSwitch) {
            langSwitch.addEventListener('change', function(e) {
                e.stopPropagation();
                if (this.value) window.location.href = this.value;
            });
            // Retire l'attribut onchange inline pour éviter le double déclenchement
            langSwitch.removeAttribute('onchange');
        }

    });

    // ── Ferme le drawer au resize vers desktop ─────────────────────────────
    window.addEventListener('resize', () => {
        if (window.innerWidth > 980) closeDrawer();
    });

    // ── Fermeture par touche Escape ────────────────────────────────────────
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && document.getElementById('mobile-drawer').classList.contains('open')) {
            closeDrawer();
        }
    });

</script>

{{-- ═══════════════════════════════════════
     MODAL GLOBAL D'ÉDITION
════════════════════════════════════════ --}}
<div class="modal fade" id="globalEditModal" tabindex="-1" aria-labelledby="globalEditModalTitle" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="background:#0e0a1c;border:1px solid rgba(233,30,140,.18);border-radius:24px;overflow:hidden;">
            <div class="modal-header" style="background:rgba(233,30,140,.06);border-bottom:1px solid rgba(255,255,255,.07);padding:18px 24px;">
                <h5 class="modal-title" id="globalEditModalTitle" style="color:#fff;font-weight:700;font-size:16px;margin:0;display:flex;align-items:center;gap:10px;">
                    <i class="bi bi-pencil-square" style="color:#e91e8c;"></i>
                    <span id="globalEditModalTitleText">{{ __('messages.btn_edit') }}</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="{{ __('messages.clt_close') }}"></button>
            </div>
            <div class="modal-body" id="globalEditModalBody" style="padding:0;overflow-y:auto;">
                <div class="text-center py-5">
                    <div class="spinner-border" style="color:#e91e8c;" role="status">
                        <span class="visually-hidden">{{ __('messages.loading') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var _editModalInstance = null;

    function getModal() {
        if (!_editModalInstance) {
            _editModalInstance = new bootstrap.Modal(document.getElementById('globalEditModal'));
        }
        return _editModalInstance;
    }

    var _i18n = {
        loading : '{{ __('messages.adm_loading') }}',
        editDefault: '{{ __('messages.btn_edit') }}',
        loadError : '{{ __('messages.adm_load_error') }}'
    };

    function showSpinner() {
        document.getElementById('globalEditModalBody').innerHTML =
            '<div class="text-center py-5"><div class="spinner-border" style="color:#e91e8c;" role="status"><span class="visually-hidden">' + _i18n.loading + '</span></div></div>';
    }

    function injectScripts(container) {
        container.querySelectorAll('script').forEach(function (orig) {
            var s = document.createElement('script');
            s.textContent = orig.textContent;
            document.body.appendChild(s);
            s.remove();
        });
    }

    function loadEditModal(url, title) {
        document.getElementById('globalEditModalTitleText').textContent = title || _i18n.editDefault;
        showSpinner();
        getModal().show();

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { return r.text(); })
            .then(function (html) {
                document.getElementById('globalEditModalBody').innerHTML = html;
                injectScripts(document.getElementById('globalEditModalBody'));
            })
            .catch(function () {
                document.getElementById('globalEditModalBody').innerHTML =
                    '<div class="text-center py-5" style="color:#f87171;">' + _i18n.loadError + '</div>';
            });
    }

    // ── Ouvre le modal au clic sur [data-edit-url] ──────────────────────────
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-edit-url]');
        if (!btn) return;
        e.preventDefault();
        loadEditModal(
            btn.getAttribute('data-edit-url'),
            btn.getAttribute('data-edit-title') || _i18n.editDefault
        );
    });

    // ── Réinitialise le modal à la fermeture ────────────────────────────────
    document.getElementById('globalEditModal').addEventListener('hidden.bs.modal', function () {
        showSpinner();
    });
})();
</script>

@stack('scripts')

<script>
(function () {
    var SCROLL_KEY = 'admin_scroll_pos';

    /* Restore scroll position after a delete redirect */
    var saved = sessionStorage.getItem(SCROLL_KEY);
    if (saved !== null) {
        sessionStorage.removeItem(SCROLL_KEY);
        window.scrollTo({ top: parseInt(saved, 10), behavior: 'instant' });
    }

    /* Save scroll position before any delete/destroy form submit */
    document.addEventListener('submit', function (e) {
        var form = e.target;
        /* Detect DELETE method: hidden _method=DELETE or method="delete" */
        var method = (form.querySelector('input[name="_method"]') || {}).value || form.method;
        if (method && method.toUpperCase() === 'DELETE') {
            sessionStorage.setItem(SCROLL_KEY, window.scrollY);
        }
    });

    /* Also cover plain delete buttons that do a GET/POST to a destroy route
       (buttons with data-confirm-delete or class containing "btn-delete") */
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-delete-url], .btn-delete, .btn-danger[href*="delete"], .btn-danger[href*="destroy"]');
        if (btn) {
            sessionStorage.setItem(SCROLL_KEY, window.scrollY);
        }
    });
})();
</script>

@include('partials.toast')
</body>
</html>