@extends('layouts.app')

@section('title', 'Hoy')

@section('content')
    <div style="margin-left: 15vw;margin-right: 15vw;">
        <div class="top-actions">

            <h2>Hoy</h2>

            <div class="points-box">
                 {{ $totalPoints }} <i class="bi bi-coin"></i>
            </div>

        </div>
        <div class="row d-flex flex-row align-items-center">
            @foreach($commonTasks as $commonTask)

                <div class="col-12 col-md-6 col-lg-3" style="cursor:pointer">
                    <form id="commonForm{{$commonTask->id}}" class="col-4 text-end" method="POST" action="{{ route('tasks.complete', $commonTask->id) }}"></form>

                    <div class="card task-card h-100 shadow-sm border-0">

                        <div class="card-body d-flex flex-column">

                            {{-- HEADER --}}
                            <div class="d-flex justify-content-between align-items-start mb-2">

                                <h5 class="fw-semibold mb-0">
                                    {{ $commonTask->name }}
                                </h5>
                            </div>
                            {{-- FOOTER --}}
                            <div class="mt-auto d-flex justify-content-end">

                                <div class="task-points" >

                                    {{ $commonTask->points }}<i class="bi bi-coin"  style="font-size: 1rem"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            @endforeach
        </div>
        <div class="today-list pt-4">

            @foreach($tasks as $task)

                <div class="today-item row {{ $task->status === 'completed' ? 'completed' : '' }}">
                    <div class="col-4 flex-grow-1">

                        <div class="fw-semibold">
                            {{ $task->task->name }}
                        </div>

                    </div>
                    <div class="col-4 flex-grow-1">
                        <div class="mt-auto d-flex justify-content-end">

                            <div class="task-points">

                                {{ $commonTask->points }}<i class="bi bi-coin"  style="font-size: 1rem"></i>

                            </div>

                        </div>
                    </div>
                    <form class="col-4 text-end" method="POST" action="{{ route('tasks.complete', $task->task->id) }}">
                        @csrf

                        <button class="check-btn">
                            ✓
                        </button>
                    </form>


                </div>

            @endforeach

        </div>
    </div>
@endsection