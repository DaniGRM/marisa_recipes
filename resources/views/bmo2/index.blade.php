<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>BMO - Sistema de Tareas</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bmo2.css') }}">
</head>

<body>
    <!-- Contenedor principal con marco -->
    <div class="bmo-screen-wrapper">
        <!-- Marco de fondo -->
        <div class="bmo-frame"></div>
        
        <!-- Contenedor de contenido escalable -->
        <div id="bmo-content-container" class="bmo-content-container">
            <div id="bmo-content" class="bmo-content h-100">
                <!-- Las pantallas se cargarán aquí dinámicamente -->
                
                @include('bmo2.screens.tasks')
                @include('bmo2.screens.common_tasks')
                @include('bmo2.screens.user-select')
                @include('bmo2.screens.filter')
                @include('bmo2.screens.confirm')
                @include('bmo2.screens.loader')
                @include('bmo2.screens.task-completed')
                @include('bmo2.screens.dni')
                @include('bmo2.screens.events.flash_moving')
                @include('bmo2.screens.events.flash_moving_confirm')
            </div>
        </div>
        @include('bmo2.screens.screensaver')

    </div>

    <!-- Variables globales -->
    <script>
        let bmo = {
            taskCompleted: @json($taskCompleted ?? null),
            currentUser: '{{ $currentUser }}',
            users: {!! $users->toJson() !!},
            currentScreen: null,
            currentFilter: '{{ $currentFilter }}',
            userFilters: {!! json_encode($userFilters) !!},
            csrfToken: '{{ csrf_token() }}',
            winningRooms: {!! json_encode($winningRooms) !!}
        };
    </script>

    <!-- Librerías externas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    
    <!-- Scripts del proyecto -->
    <script src="{{ asset('js/screens/screen-registry.js') }}"></script>
    <script src="{{ asset('js/screens/card-dni.js') }}"></script>
    <script src="{{ asset('js/screens/card-dni-flipper.js') }}"></script>
    <script src="{{ asset('js/screens/filter-manager.js') }}"></script>
    <script src="{{ asset('js/bmo2.js') }}"></script>
</body>

</html>