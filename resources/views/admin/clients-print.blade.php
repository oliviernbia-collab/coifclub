{{-- resources/views/admin/client-print.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Fiche Client - {{ $client->name }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body{
            background:#f4f6f9;
            padding:40px;
            color:#222;
        }

        .print-container{
            max-width:900px;
            margin:auto;
            background:#fff;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
        }

        /* HEADER */
        .print-header{
            background:linear-gradient(135deg,#111827,#1f2937);
            color:white;
            padding:30px 40px;
            display:flex;
            align-items:center;
            justify-content:space-between;
        }

        .logo-box{
            display:flex;
            align-items:center;
            gap:20px;
        }

        .logo{
            width:20%;
            height:20%;
            border-radius:10%;
            overflow:hidden;
            border:4px solid rgba(255,255,255,0.2);
            background:#fff;
        }

        .logo img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .salon-info h1{
            font-size:28px;
            margin-bottom:5px;
        }

        .salon-info p{
            opacity:.8;
            font-size:14px;
        }

        .document-title{
            text-align:right;
        }

        .document-title h2{
            font-size:24px;
            margin-bottom:8px;
        }

        .document-title span{
            font-size:14px;
            opacity:.8;
        }

        /* BODY */
        .content{
            padding:40px;
        }

        .client-card{
            background:#f9fafb;
            border-radius:18px;
            padding:30px;
            border:1px solid #e5e7eb;
        }

        .client-header{
            display:flex;
            align-items:center;
            gap:20px;
            margin-bottom:30px;
        }

        .avatar{
            width:90px;
            height:90px;
            border-radius:50%;
            background:#111827;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:35px;
            font-weight:bold;
        }

        .client-header h3{
            font-size:28px;
            margin-bottom:5px;
        }

        .badge{
            display:inline-block;
            background:#dcfce7;
            color:#166534;
            padding:6px 14px;
            border-radius:30px;
            font-size:13px;
            font-weight:600;
        }

        .info-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:20px;
            margin-top:25px;
        }

        .info-box{
            background:white;
            border-radius:14px;
            padding:20px;
            border:1px solid #e5e7eb;
        }

        .info-box span{
            display:block;
            font-size:13px;
            color:#6b7280;
            margin-bottom:8px;
        }

        .info-box h4{
            font-size:18px;
            color:#111827;
        }

        .footer{
            margin-top:40px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            font-size:14px;
            color:#6b7280;
        }

        .print-btn{
            margin-top:30px;
            text-align:center;
        }

        .print-btn button{
            background:#111827;
            color:white;
            border:none;
            padding:14px 30px;
            border-radius:50px;
            font-size:15px;
            cursor:pointer;
            transition:.3s;
        }

        .print-btn button:hover{
            background:#000;
        }

        @media print{

            body{
                background:white;
                padding:0;
            }

            .print-container{
                box-shadow:none;
                border-radius:0;
            }

            .print-btn{
                display:none;
            }
        }
    </style>
</head>
<body>

<div class="print-container">

    {{-- HEADER --}}
    <div class="print-header">

        <div class="logo-box">

            <div class="logo">

                {{-- Logo du salon --}}
                <img src="{{ asset('images/C34.jpg') }}" alt="Logo">

            </div>

            <div class="salon-info">
                <h1>{{ $salon->name ?? 'Marol Hair' }}</h1>

                <p>
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $salon->address ?? 'USA ' }}
                </p>
            </div>

        </div>

        <div class="document-title">
            <h2>Fiche Client</h2>
            <span>{{ now()->format('d/m/Y H:i') }}</span>
        </div>

    </div>

    {{-- CONTENT --}}
    <div class="content">

        <div class="client-card">

            <div class="client-header">

                <div class="avatar">
                    {{ strtoupper(substr($client->name,0,1)) }}
                </div>

                <div>
                    <h3>{{ $client->name }}</h3>

                    <span class="badge">
                        Client enregistré
                    </span>
                </div>

            </div>

            <div class="info-grid">

                <div class="info-box">
                    <span>Email</span>
                    <h4>{{ $client->email }}</h4>
                </div>

                <div class="info-box">
                    <span>Téléphone</span>
                    <h4>{{ $client->phone ?? 'Non renseigné' }}</h4>
                </div>

                <div class="info-box">
                    <span>Date d'inscription</span>
                    <h4>{{ $client->created_at->format('d/m/Y') }}</h4>
                </div>

                <div class="info-box">
                    <span>Réservations</span>
                    <h4>{{ $client->reservationsAsClient()->count() }}</h4>
                </div>

            </div>

            <div class="footer">

                <div>
                    Document généré par l'administration
                </div>

                <div>
                    Signature : __________________
                </div>

            </div>

        </div>

        {{-- BOUTON IMPRIMER --}}
        <div class="print-btn">

            <button onclick="window.print()">
                <i class="fa-solid fa-print"></i>
                Imprimer la fiche
            </button>

            <button onclick="window.location.href = '{{ route('admin.clients') }}'">
                <i class="fa-solid fa-arrow-left"></i>
                Retour
            </button>

        </div>

    </div>

</div>

</body>
</html>