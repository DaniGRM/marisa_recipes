<div class="bmo-screen" data-screen="tasks">
    <div class="tasks">

        @foreach($tasks as $task)

            <div class="task {{ $task->status === 'completed' ? 'completed' : ($task->status === 'rejected' ? 'rejected' : '') }}"
                @if($task->status === 'pending' || $task->status === 'rejected')
                    onclick='bmoApp.completeTaskConfirm({{ $task->task->id }}, {{ json_encode($task->task->description) }}, false)'
                @elseif($task->status === 'completed')
                    onclick='bmoApp.rejectTaskConfirm({{ $task->id }}, {{ json_encode($task->task->name) }})'
                @endif
                data-room="{{ $task->task->room->name ?? '' }}" style="--i: {{ $loop->index }}">

                <span>
                    {{ $task->task->name }}
                </span>

                @if($task->status === 'pending')

                    <form id="formTask{{ $task->task->id }}" method="POST"
                        action="{{ route('bmo.tasks.complete', $task->task->id) }}">
                        @csrf
                        <input type="hidden" name="user" id="user{{ $task->task->id }}" value="{{$currentUser }}">
                    </form>

                @else
                    <img class="me-5" @if($task->completedBy && $task->completedBy->id == 1) src="icons/header/bmo.png" @else src="" @endif></img>
                @endif
                <div class="task-btn-container">
                    <img src="{{ $task->task->room->icon_path }}" alt="" style="height: 100px">
                    <div class="points d-flex">
                        <span class="px-3 btn-background level{{ $task->bonus_level != 0 ? $task->bonus_level : '' }}"> {{ $task->task->points + $task->bonus }}</span>
                    </div>
                </div>
                
            </div>

        @endforeach

    </div>
</div>