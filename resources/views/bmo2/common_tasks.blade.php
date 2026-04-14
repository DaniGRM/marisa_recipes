<div class="bmo-screen" data-screen="common_tasks">
    @include('bmo2.components.header')
    <div class="tasks">

        @foreach($commonTasks as $task)
            <form id="formCommonTask{{ $task->id }}" method="POST"
                action="{{ route('bmo.tasks.complete', $task->id) }}">
                @csrf
                <input type="hidden" name="user" id="user{{ $task->id }}" value="{{$currentUser }}">
            </form>
            <div class="common-task" onclick="completeCommonTaskConfirm({{ $task->id }})" data-room="{{ $task->room->name ?? '' }}">
                <span>
                    {{ $task->name }}
                </span>
            </div>
        @endforeach

    </div>
</div>