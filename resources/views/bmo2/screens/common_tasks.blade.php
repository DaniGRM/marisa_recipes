<div class="bmo-screen" data-screen="common_tasks">
    @include('bmo2.components.header')
    <div class="row ">

        @foreach($commonTasks as $task)
            <div class="col-6">
            <div class="task" onclick="bmoApp.completeTaskConfirm({{ $task->id }}, '{{ $task->description }}', true)"  data-room="{{ $task->room->name ?? '' }}">

                <span>
                    {{ $task->name }}
                </span>


                <form id="formCommonTask{{ $task->id }}" method="POST"
                    action="{{ route('bmo.tasks.complete', $task->id) }}">
                    @csrf
                    <input type="hidden" name="user" id="user{{ $task->id }}" value="{{$currentUser }}">
                </form>

                
                <div class="task-btn-container commons">
                    <img src="{{ $task->room->icon_path }}" alt="" style="height: 100px">
                    <div class="points d-flex">
                        <span class="px-3 btn-background ms-5"> {{ $task->points }}</span>
                    </div>
                </div>
                
            </div>
            </div>

        @endforeach

    </div>
</div>