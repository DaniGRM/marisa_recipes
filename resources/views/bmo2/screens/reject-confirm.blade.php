<div class="bmo-screen" data-screen="reject-confirm">
    <div class="loader-content d-flex flex-column justify-content-around h-100">

        <div class="bmo-message">
            ¿Revocar esta tarea? Se restarán los puntos obtenidos.
            <br>
            <span id="rejectTaskDescription" class="confirm-description"></span>
        </div>

        <div class="bmo-message d-flex">
            <button class="confirm-button confirm-button--reject" id="rejectInstanceBtn" onclick="bmoApp.rejectTask()">SI</button>
            <button class="confirm-button" onclick="bmoApp.cancelRejectTask()">NO</button>
        </div>

        @foreach($tasks as $task)
            @if($task->status === 'completed')
                <form id="formRejectInstance{{ $task->id }}" method="POST"
                    action="{{ route('bmo.task_instances.reject', $task->id) }}">
                    @csrf
                </form>
            @endif
        @endforeach

    </div>
</div>
