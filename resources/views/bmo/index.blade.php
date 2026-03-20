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
</body>
<script>
    let selectedUser = '{{$currentUser }}';
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script src="{{ asset('js/bmo.js') }}"></script>
</html>