<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:"Segoe UI",sans-serif; }

        body{ background:#f4f6f9; padding:40px; color:#222; }

        .print-container{
            max-width:1000px;
            margin:auto;
            background:#fff;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
        }

        /* ── HEADER ── */
        .print-header{
            background:linear-gradient(135deg,#111827,#1f2937);
            color:#fff;
            padding:30px 40px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
        }

        .logo-box{ display:flex; align-items:center; gap:20px; }

        .logo{
            width:70px; height:70px;
            border-radius:14px;
            overflow:hidden;
            border:3px solid rgba(255,255,255,.2);
            background:#fff;
            flex-shrink:0;
        }
        .logo img{ width:100%; height:100%; object-fit:cover; }

        .salon-info h1{ font-size:24px; margin-bottom:4px; }
        .salon-info p{ opacity:.7; font-size:13px; }

        .doc-meta{ text-align:right; }
        .doc-meta h2{ font-size:20px; margin-bottom:6px; }
        .doc-meta .doc-date{ font-size:13px; opacity:.7; }
        .doc-meta .doc-count{
            display:inline-block;
            margin-top:8px;
            background:rgba(212,175,55,.25);
            color:#D4AF37;
            padding:4px 14px;
            border-radius:999px;
            font-size:12px;
            font-weight:700;
            border:1px solid rgba(212,175,55,.3);
        }

        /* ── STATS BAND ── */
        .stats-band{
            background:linear-gradient(135deg,#1a1230,#0f172a);
            padding:20px 40px;
            display:flex;
            gap:0;
        }
        .stat-item{
            flex:1;
            text-align:center;
            padding:0 20px;
            border-right:1px solid rgba(255,255,255,.08);
        }
        .stat-item:last-child{ border-right:none; }
        .stat-num{ font-size:1.6rem; font-weight:800; color:#D4AF37; }
        .stat-lbl{ font-size:11px; color:rgba(255,255,255,.5); text-transform:uppercase; letter-spacing:.06em; margin-top:2px; }

        /* ── CONTENT ── */
        .content{ padding:32px 40px; }

        .section-title{
            font-size:13px;
            font-weight:700;
            color:#6b7280;
            text-transform:uppercase;
            letter-spacing:.08em;
            margin-bottom:16px;
            display:flex;
            align-items:center;
            gap:8px;
        }
        .section-title::after{
            content:'';
            flex:1;
            height:1px;
            background:#e5e7eb;
        }

        /* ── TABLE ── */
        .users-table{
            width:100%;
            border-collapse:collapse;
        }

        .users-table thead tr{
            background:linear-gradient(135deg,#111827,#1f2937);
        }

        .users-table thead th{
            color:rgba(255,255,255,.75);
            font-size:11px;
            font-weight:600;
            text-transform:uppercase;
            letter-spacing:.08em;
            padding:13px 16px;
            text-align:left;
        }

        .users-table tbody tr{ border-bottom:1px solid #f3f4f6; transition:.15s; }
        .users-table tbody tr:last-child{ border-bottom:none; }
        .users-table tbody tr:nth-child(even){ background:#fafafa; }

        .users-table tbody td{ padding:13px 16px; font-size:13.5px; color:#374151; vertical-align:middle; }

        .user-cell{ display:flex; align-items:center; gap:10px; }

        .user-avatar{
            width:36px; height:36px; border-radius:10px;
            background:linear-gradient(135deg,#111827,#374151);
            color:#fff; font-weight:700; font-size:13px;
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0;
        }
        .user-avatar.role-admin{ background:linear-gradient(135deg,#D4AF37,#B8860B); color:#0f172a; }
        .user-avatar.role-employee{ background:linear-gradient(135deg,#6b21a8,#9333ea); }
        .user-avatar.role-client{ background:linear-gradient(135deg,#0891b2,#0e7490); }

        .user-name{ font-weight:600; color:#111827; font-size:13.5px; }
        .user-email{ font-size:11.5px; color:#9ca3af; margin-top:1px; }

        .role-badge{
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 12px; border-radius:999px;
            font-size:11px; font-weight:700;
        }
        .badge-admin   { background:#fef3c7; color:#92400e; }
        .badge-employee{ background:#ede9fe; color:#6b21a8; }
        .badge-client  { background:#e0f2fe; color:#0369a1; }
        .badge-default { background:#f3f4f6; color:#4b5563; }

        .date-col{ color:#9ca3af; font-size:12px; white-space:nowrap; }

        /* ── FOOTER ── */
        .print-footer{
            padding:20px 40px;
            border-top:1px solid #f3f4f6;
            display:flex;
            justify-content:space-between;
            align-items:center;
            font-size:12px;
            color:#9ca3af;
        }

        /* ── BUTTONS ── */
        .btn-wrap{ padding:24px 40px; display:flex; gap:12px; justify-content:center; }

        .btn-print{
            background:#111827; color:#fff; border:none;
            padding:13px 28px; border-radius:50px;
            font-size:14px; font-weight:600; cursor:pointer;
            display:inline-flex; align-items:center; gap:8px; transition:.25s;
        }
        .btn-print:hover{ background:#000; }

        .btn-back{
            background:#f3f4f6; color:#374151; border:none;
            padding:13px 28px; border-radius:50px;
            font-size:14px; font-weight:600; cursor:pointer;
            display:inline-flex; align-items:center; gap:8px; transition:.25s;
            text-decoration:none;
        }
        .btn-back:hover{ background:#e5e7eb; }

        @media print{
            body{ background:#fff; padding:0; }
            .print-container{ box-shadow:none; border-radius:0; }
            .btn-wrap{ display:none; }
        }
    </style>
</head>
<body>

<div class="print-container">

    {{-- HEADER --}}
    <div class="print-header">
        <div class="logo-box">
            <div class="logo">
                <img src="{{ asset('images/C34.jpg') }}" alt="Logo">
            </div>
            <div class="salon-info">
                <h1>CoifClub</h1>
                <p><i class="fa-solid fa-location-dot"></i> Salon de coiffure premium</p>
            </div>
        </div>
        <div class="doc-meta">
            <h2>Liste des utilisateurs</h2>
            <div class="doc-date"><i class="fa-regular fa-calendar"></i> {{ now()->format('d/m/Y à H:i') }}</div>
            <div class="doc-count"><i class="fa-solid fa-users"></i> {{ $users->count() }} utilisateurs</div>
        </div>
    </div>

    {{-- STATS BAND --}}
    @php
        $admins    = $users->where('role','admin')->count();
        $employees = $users->where('role','employee')->count();
        $clients   = $users->where('role','client')->count();
    @endphp
    <div class="stats-band">
        <div class="stat-item">
            <div class="stat-num">{{ $users->count() }}</div>
            <div class="stat-lbl">Total</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">{{ $admins }}</div>
            <div class="stat-lbl">Admins</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">{{ $employees }}</div>
            <div class="stat-lbl">Employés</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">{{ $clients }}</div>
            <div class="stat-lbl">Clients</div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="content">

        <div class="section-title">
            <i class="fa-solid fa-table-list" style="color:#D4AF37;"></i>
            Répertoire complet
        </div>

        <table class="users-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Utilisateur</th>
                    <th>Rôle</th>
                    <th>Téléphone</th>
                    <th>Inscrit le</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $i => $user)
                @php
                    $roleClass = match($user->role ?? '') {
                        'admin'    => 'role-admin',
                        'employee' => 'role-employee',
                        'client'   => 'role-client',
                        default    => '',
                    };
                    $badgeClass = match($user->role ?? '') {
                        'admin'    => 'badge-admin',
                        'employee' => 'badge-employee',
                        'client'   => 'badge-client',
                        default    => 'badge-default',
                    };
                    $roleIcon = match($user->role ?? '') {
                        'admin'    => 'fa-crown',
                        'employee' => 'fa-scissors',
                        'client'   => 'fa-user',
                        default    => 'fa-circle-user',
                    };
                @endphp
                <tr>
                    <td style="color:#d1d5db;font-size:12px;font-weight:600;">{{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar {{ $roleClass }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-email">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge {{ $badgeClass }}">
                            <i class="fa-solid {{ $roleIcon }}"></i>
                            {{ ucfirst($user->role ?? 'N/A') }}
                        </span>
                    </td>
                    <td class="date-col">{{ $user->phone ?? '—' }}</td>
                    <td class="date-col">{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    {{-- FOOTER --}}
    <div class="print-footer">
        <div>Document généré par l'administration · CoifClub</div>
        <div>Signature : __________________</div>
    </div>

    {{-- BUTTONS --}}
    <div class="btn-wrap">
        <button class="btn-print" onclick="window.print()">
            <i class="fa-solid fa-print"></i> Imprimer
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Retour
        </a>
    </div>

</div>

</body>
</html>
