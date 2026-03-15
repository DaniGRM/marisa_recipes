<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Marisa Recipes')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body{
            font-family: 'Press Start 2P', 'Poppins', sans-serif;
            font-size: 12px;
            background: linear-gradient(180deg,#33b8a5,#1ea896);
            min-height:100vh;
            display:flex;
            flex-direction:column;
            color:#083c3a;
        }

        main{
            flex:1;
        }
        h1{
            font-size: 20px;
        }
        h2{
            font-size: 19px;
        }
        h3{
            font-size: 18px;
        }
        h4{
            font-size: 17px;
        }
        h5{
            font-size: 16px;
        }

        /* Título estilo consola */
        .brand-title{
            font-family:'Press Start 2P', monospace;
            letter-spacing:2px;
            color:#fff;
        }

        /* Panel principal tipo pantalla BMO */
        .hero{
            background-color: #083c3a;
            color: #fff;
            border-radius:24px;
            padding:40px;
            box-shadow:
                0 20px 40px rgba(0,0,0,0.25),
                inset 0 2px 0 rgba(255,255,255,0.4);
        }

        /* Footer integrado en el estilo */
        footer{
            background:#1c8f83;
            color:#d6fff4;
        }

        /* Tarjetas tipo botones de BMO */
        .recipe-card{
            border:none;
            border-radius:22px;
            background:#9fe0c6 !important;
            color:#083c3a!important;
            transition:all .2s ease;
            box-shadow:
                0 14px 30px rgba(0,0,0,0.25),
                inset 0 2px 0 rgba(255,255,255,0.4);
        }

        .recipe-card:hover{
            transform:translateY(-6px);
            box-shadow:
                0 18px 40px rgba(0,0,0,0.35),
                inset 0 2px 0 rgba(255,255,255,0.5);
        }
        
        .card{
            background-color: #083c3a;
            color: #fff;
        }

        /* Badges estilo pixel */
        .badge{
            font-family:'Press Start 2P', monospace;
            padding:8px 10px;
            border-radius:10px;
        }

        .badge-type-0{
            background:#6fd6ff;
            color:#083c3a;
        }

        .badge-type-1{
            background:#ff6f6f;
            color:#083c3a;
        }

        .badge-type-2{
            background:#ffd86f;
            color:#083c3a;
        }

        .badge-type-single{
            background:#7dd6c0;
            color:#083c3a;
        }

        /* Barra superior */
        .top-actions{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        /* Botones estilo consola */
        .btn-bmo{
            background:#9fe0c6;
            border:none;
            border-radius:16px;
            padding:12px 20px;
            font-family:'Press Start 2P', monospace;
            box-shadow:
                0 10px 20px rgba(0,0,0,0.25),
                inset 0 2px 0 rgba(255,255,255,0.5);
        }

        .btn-bmo:hover{
            transform:translateY(-2px);
        }

        .form-control{
            font-size: 12px;
        }
        .form-select{
            font-size: 12px;
        }
    </style>

    @stack('styles')
</head>
<body>

@include('layouts.header')

<main class="container py-5">
    @yield('content')
</main>

@include('layouts.footer')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@stack('scripts')

</body>
</html>