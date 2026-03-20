<div class="tasks">

    @foreach($tasks as $task)

        <div class="task {{ $task->status === 'completed' ? 'completed' : '' }}">

            <span>
                {{ $task->task->name }}
            </span>

            @if($task->status !== 'completed')

                <form id="formTask{{ $task->task->id }}" method="POST"
                    action="{{ route('bmo.tasks.complete', $task->task->id) }}">
                    @csrf
                    <input type="hidden" name="user" id="user{{ $task->task->id }}" value="{{$currentUser }}">
                    <button type="button" class="btn btn-lg" onclick="completeTask({{ $task->task->id }})">OK</button>
                </form>

            @else
                <span>
                    {{ $task->completedBy->name }}
                </span>
            @endif
            <span class="points">
                ⭐ {{ $task->task->points }}
            </span>
        </div>

    @endforeach

</div>