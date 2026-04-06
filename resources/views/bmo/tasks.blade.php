<div class="tasks">

    @foreach($tasks as $task)

        <div class="task {{ $task->status === 'completed' ? 'completed' : '' }}" @if($task->status ==='pending') onclick="completeTaskConfirm({{ $task->task->id }})" @endif>

            <span>
                {{ $task->task->name }}
            </span>

            @if($task->status !== 'completed')

                <form id="formTask{{ $task->task->id }}" method="POST"
                    action="{{ route('bmo.tasks.complete', $task->task->id) }}">
                    @csrf
                    <input type="hidden" name="user" id="user{{ $task->task->id }}" value="{{$currentUser }}">
                </form>

            @else
                <span>
                    {{ $task->completedBy->name }}
                </span>
            @endif
            <div class="points d-flex">
                <span class="px-3"> {{ $task->task->points }}</span>
            </div>
        </div>

    @endforeach

</div>