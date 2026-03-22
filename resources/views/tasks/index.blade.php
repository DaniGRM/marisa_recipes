@extends('layouts.app')

@section('title', 'Tasks')

@section('content')

    <div class="top-actions">

        <h2 class="mb-0">
            Tareas
        </h2>

        <button class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createTaskModal">

            + Nueva tarea

        </button>

    </div>

    <div class="row g-4">

        @foreach($tasks as $task)

            <div class="col-12 col-md-6 col-lg-3">

                <div class="card task-card h-100 shadow-sm border-0" data-id="{{ $task->id }}" data-name="{{ $task->name }}"
                    data-description="{{ $task->description }}" data-points="{{ $task->points }}" data-type="{{ $task->type }}"
                    data-times="{{ $task->schedule->times ?? '' }}" data-every="{{ $task->schedule->every_n_units ?? '' }}"
                    data-frequency="{{ $task->schedule->frequency ?? '' }}">

                    <div class="card-body d-flex flex-column">

                        {{-- HEADER --}}
                        <div class="d-flex justify-content-between align-items-start mb-2">

                            <h5 class="fw-semibold mb-0">
                                {{ $task->name }}
                            </h5>

                            <span class="badge badge-type-{{ $task->type }}">
                                {{ $types[$task->type] }}
                            </span>

                        </div>

                        {{-- DESCRIPTION --}}
                        @if($task->description)
                            <p class="fs-10 mb-3">
                                {{ $task->description }}
                            </p>
                        @endif


                        {{-- FREQUENCY --}}
                        @if($task->schedule)

                            <div class="task-frequency mb-3">

                                <i class="bi bi-arrow-repeat me-1"></i>

                                {{$task->schedule->times}}
                                veces cada
                                {{$task->schedule->every_n_units}}
                                {{ $frequencies[$task->schedule->frequency] }}

                            </div>

                        @endif


                        {{-- FOOTER --}}
                        <div class="mt-auto d-flex justify-content-end">

                            <div class="task-points">

                                {{ $task->points }}⭐

                            </div>

                        </div>
                        @if($task->room)
                            <div class="task-room text-white mb-2">
                                <i class="bi bi-house-door me-1" style="font-size: 20px;"></i>
                                {{ $task->room->name }}
                            </div>
                        @endif

                    </div>

                </div>

            </div>

        @endforeach

    </div>

    {{-- MODAL CREAR --}}

    <div class="modal fade" id="createTaskModal">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content rounded-4 border-0 shadow-lg">

                <div class="modal-header border-0">

                    <h5>Nueva tarea</h5>

                    <button class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <form method="POST" action="{{route('tasks.store')}}" id="taskForm">

                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">

                                Nombre

                            </label>

                            <input name="name" class="form-control" id="taskName">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Descripción

                            </label>

                            <textarea name="description" class="form-control" id="taskDescription"></textarea>

                        </div>
                        <div class="mb-3">

                            <label class="form-label">
                                Puntos
                            </label>

                            <input type="number" name="points" class="form-control" min="1" value="1" id="taskPoints">

                            <div class="form-text">
                                Valor de completar la tarea
                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Tipo

                            </label>

                            <select name="type" class="form-select" id="typeSelect" >

                                @foreach($types as $id => $type)

                                    <option value="{{$id}}">

                                        {{$type}}

                                    </option>

                                @endforeach

                            </select>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Habitación</label>

                            <select name="room"
                                    id="roomSelect"
                                    class="form-select"
                                    required>

                                @foreach($rooms as $room)
                                    <option value="{{ $room }}">{{ $room }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div id="scheduleFields" style="display:none">

                            <label class="form-label mb-3">
                                Frecuencia
                            </label>

                            <div class="frequency-builder d-flex align-items-center gap-2 flex-wrap">

                                <span>Repetir</span>

                                <input type="number" name="times" class="form-control text-center" style="width:80px"
                                    value="1" min="1" id="taskTimes">

                                <span>veces cada</span>

                                <input type="number" name="every_n_units" class="form-control text-center"
                                    style="width:80px" value="1" min="1" id="taskEvery" >

                                <select name="frequency" class="form-select" style="width:150px" id="taskFrequency">

                                    @foreach($frequencies as $id => $frequency)
                                        <option value="{{$id}}">
                                            {{$frequency}}
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer border-0">

                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">

                            Cancelar

                        </button>

                        <button class="btn btn-dark rounded-pill px-4">

                            Guardar

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

@push('scripts')

    <script>

        $('#typeSelect').on('change', function () {

            if ($(this).val() === 'frequency') {
                $('#scheduleFields').show();
            } else {
                $('#scheduleFields').hide();
            }

        });

        $('.frequency-builder input[name="times"]').on('input', function () {

            let val = parseInt($(this).val())

            if (val === 1) {
                $(this).nextAll('span').first().text('vez cada')
            } else {
                $(this).nextAll('span').first().text('veces cada')
            }

        });

        $('.task-card').on('click', function () {

            const modal = $('#createTaskModal');

            // Cambiar acción del form
            const id = $(this).data('id');
            $('#taskForm').attr('action', '/tasks/' + id);
            $('#formMethod').val('PUT');

            // Rellenar campos
            $('#taskName').val($(this).data('name'));
            $('#taskDescription').val($(this).data('description'));
            $('#taskPoints').val($(this).data('points'));
            $('#typeSelect').val($(this).data('type')).trigger('change');

            // Frecuencia
            $('#taskTimes').val($(this).data('times'));
            $('#taskEvery').val($(this).data('every'));
            $('#taskFrequency').val($(this).data('frequency'));

            // Mostrar modal
            modal.modal('show');
        });
        $('#createTaskModal').on('hidden.bs.modal', function () {

            $('#taskForm').attr('action', '{{ route("tasks.store") }}');
            $('#formMethod').val('POST');

            $('#taskForm')[0].reset();
            $('#scheduleFields').hide();

        });

        $('.task-card button').on('click', function(e){
            e.stopPropagation();
        });

        $('#roomSelect').select2({
            tags: true,
            placeholder: "Seleccionar o crear habitación",
            width: '100%',
            dropdownParent: $('#createTaskModal'),
        });
    </script>

@endpush