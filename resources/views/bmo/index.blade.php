<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>BMO</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bmo.css') }}">
</head>

<body>
    @include('bmo.screensaver')
    <div id="app" class="screen" style="display: none">
        @include('bmo.header')

        <div id="view-tasks" class="bmo-view">
            @include('bmo.tasks')
        </div>

        <div id="view-common-tasks" class="bmo-view" style="display:none;">
            @include('bmo.common-tasks')
        </div>
    </div>
    @include('bmo.user-select')
    @include('bmo.task-completed')
    <div id="bmo-loader" class="bmo-loader">
        <div class="loader-content">

            <div class="spinner"></div>

            <div class="loader-text">
                Procesando...
            </div>

        </div>
    </div>
    <div id="user-card-screen" class="bmo-overlay" style="display: none;">

        
        <div id="user-card-info-screen" class="bmo-screen active">

            <div class="user-card-container text-black p-4">

                <div class="d-flex h-100 align-items-start justify-content-between gap-3 mb-4 w-100">
                    
                    <div class="user-photo w-25">
                        <img src="" alt="Usuario" id="userCardImg" class="user-img w-100 h-auto" style="object-fit:cover;">
                    </div>

                    
                    <div class="user-info w-75 p-6 h-100 d-flex flex-column flex-wrap align-content-between justify-content-between">
                        <h2 id="userCardName" class="mb-2 text-uppercase"></h2>
                        <p id="userCardPoints">0 <i class="bi bi-coin"></i> </p>
                        <p id="userCardTasksCompleted">Tareas completadas: 0</p>
                    </div>
                </div>

                
                <div class="text-end mt-auto d-flex justify-content-between">
                    <div class="icon reverse-card mx-4">
                        <i class="bi bi-repeat"></i>
                    </div>
                    <button id="closeUserCard" class="btn btn-light rounded-pill px-4">Volver</button>
                </div>

            </div>

        </div>

    </div>
</body>
<script>
    let taskCompleted = @json($taskCompleted ?? null);
    let selectedUser = '{{$currentUser }}';
    let users = {!! $users !!};
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script src="{{ asset('js/bmo.js') }}"></script>

</html>