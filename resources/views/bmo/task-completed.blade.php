<div id="task-completed" class="bmo-overlay" style="display: none;">

    {{-- Pantalla imagen --}}
    <div id="bmo-image-screen" class="bmo-screen active">
        <img src="{{ asset('bmo-fun.jpg') }}" class="w-100 h-100 object-fit-cover">
    </div>

    {{-- Pantalla texto --}}
    <div id="bmo-text-screen" class="bmo-screen ">

        <div class="bmo-message">

            <p>OLE BMO OLE!!</h1>

            <p>
                TAREA COMPLETADA: <br>
                <strong>{{ $taskCompleted->task->name ?? '' }}</strong>
            </p>

            <p>
                Puntos obtenidos: 
                <strong>{{ $taskCompleted->task->points ?? 0 }}</strong> puntos
            </p>

        </div>

    </div>

</div>