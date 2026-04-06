<div class="common-tasks">

    @foreach($commonTasks as $task)
        <form id="formCommonTask{{ $task->id }}" method="POST"
            action="{{ route('bmo.tasks.complete', $task->id) }}">
            @csrf
            <input type="hidden" name="user" id="user{{ $task->id }}" value="{{$currentUser }}">
        </form>
        <div class="common-task" onclick="completeCommonTaskConfirm({{ $task->id }})">
            <span>
                {{ $task->name }}
            </span>
        </div>
    @endforeach

</div>