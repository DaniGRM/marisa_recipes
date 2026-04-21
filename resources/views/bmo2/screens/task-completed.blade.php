<div class="bmo-screen" data-screen="task-completed" style="z-index: 9999">
    <div class="task-completed-container d-flex flex-column h-100">
        
        {{-- Pantalla imagen --}}
        <div class="task-completed-image-screen active">
            <img src="{{ asset('bmo-fun.jpg') }}" class="w-100 h-100 object-fit-cover" alt="¡Tarea completada!">
        </div>

        {{-- Pantalla texto --}}
        <div class="task-completed-text-screen h-100">
            <div class="bmo-message h-100" style="    display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-top: 20px;
            padding-bottom: 20px;">
                <p class="task-completed-title">¡OLE BMO OLE!!</p>

                <p class="task-completed-info">
                    TAREA COMPLETADA: <br>
                    <strong id="completedTaskName">{{ $taskCompleted->task->name ?? '' }}</strong>
                </p>

                <p class="task-completed-points">
                    Puntos obtenidos:<br>
                    <strong id="completedTaskPoints">{{ $taskCompleted->task->points ?? 0 }}</strong> puntos
                </p>
            </div>
        </div>

    </div>
</div>

<canvas id="confetti-canvas" style="
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 10000;
    display: none;
"></canvas>
