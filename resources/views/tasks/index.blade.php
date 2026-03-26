@extends('layouts.app')

@section('title', 'Tasks')

@section('content')

    <div class="top-actions">

        <h2 class="mb-0">
            Tareas
        </h2>

        <button class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createTaskModal"
            id="#createTaskModalBtn">

            + Nueva tarea

        </button>

    </div>
    <div class="filters d-flex gap-2 mb-4">

        <select id="filterType" class="form-select" style="max-width:400px">
            <option value="">Todos los tipos</option>
            @foreach($types as $id => $type)
                <option value="{{ $id }}">{{ $type }}</option>
            @endforeach
        </select>

        <select id="filterRoom" class="form-select" style="max-width:400px">
            <option value="">Todas las habitaciones</option>
            @foreach($rooms as $room)
                <option value="{{ $room }}">{{ $room }}</option>
            @endforeach
        </select>

    </div>

    <div class="row g-4">

        @foreach($tasks as $task)
            @if($task->type == 'linked')
                @continue
            @endif
            <div class="col-12 col-md-6 col-lg-3">

                <div class="card task-card h-100 border-0 shadow-sm p-3 task-item"
                data-id="{{ $task->id }}"
                data-name="{{ $task->name }}"
                data-description="{{ $task->description }}"
                data-points="{{ $task->points }}"
                data-type="{{ $task->type }}"
                data-room="{{ $task->room->name ?? '' }}"
                data-times="{{ $task->schedule->times ?? '' }}"
                data-every="{{ $task->schedule->every_n_units ?? '' }}"
                data-frequency="{{ $task->schedule->frequency ?? '' }}">

                    <div class="d-flex flex-column h-100">

                        {{-- TOP BAR --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <span class="badge badge-type-{{ $task->type }}">
                                {{ $types[$task->type] }}
                            </span>

                            <div class="task-points small fw-semibold">
                                ⭐ {{ $task->points }}
                            </div>

                        </div>

                        {{-- TITLE --}}
                        <h5 class="fw-semibold mb-2">
                            {{ $task->name }}
                        </h5>

                        {{-- DESCRIPTION --}}
                        @if($task->description)
                            <p class="small mb-3">
                                {{ $task->description }}
                            </p>
                        @endif

                        {{-- SPACER --}}
                        <div class="mt-auto">

                            {{-- FREQUENCY --}}
                            @if($task->schedule)
                                <div class="task-frequency small mb-2 text-muted w-100">
                                    <i class="bi bi-arrow-repeat me-1" style="font-size: 16px;"></i>
                                    {{$task->schedule->times}}
                                    {{$task->schedule->times == 1 ? 'vez' : 'veces'}}
                                    cada
                                    {{$task->schedule->every_n_units}}
                                    {{ $frequencies[$task->schedule->frequency] }}
                                </div>
                            @endif

                            {{-- ROOM --}}
                            <div class="d-flex w-100 justify-content-between mt-2">

                                @if($task->room)
                                    <div class="task-room text-white mb-2">
                                        <i class="bi bi-house-door me-1" style="font-size: 20px;"></i>
                                        {{ $task->room->name }}
                                    </div>
                                @endif
                                <div class="row">
                                    @if($task->linkedTasks->count())
                                    <div class="col-6">
                                        <button class="btn btn-sm btn-light show-linked"
                                                data-id="{{ $task->id }}">
                                            <i class="bi bi-list-nested"></i>
                                        </button>
                                    </div>
                                    @endif
                                    <div class="col-6">
                                    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="delete-task-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar tarea">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

            </div>

        @endforeach

    </div>

    {{-- MODAL CREAR --}}

    @include('tasks.task-modal')
    @include('tasks.linked-task-modal')

    

@endsection

@push('scripts')

    <script>
        const tasks = @json($tasks);
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
            currentTaskId = $(this).data('id');
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

        $('.task-card button').on('click', function (e) {
            e.stopPropagation();
        });

        $('#roomSelect').select2({
            tags: true,
            placeholder: "Seleccionar o crear habitación",
            width: '100%',
            dropdownParent: $('#createTaskModal'),
        });

        let currentTaskId = null;

        $("#createTaskModalBtn").on('click', function () {

            currentTaskId = null;

            // resto de tu lógica...
        });

        $('#createLinkedTaskBtn').on('click', function () {
            if (!currentTaskId) return;

            // limpiar formulario
            $('#taskForm')[0].reset();
            $('#taskForm').attr('action', '{{ route("tasks.store") }}');
            $('#formMethod').val('POST');
            // setear linked
            $('#linkedTaskId').val(currentTaskId);
            console.log($("#linkedTaskId").val());
            // ocultar tipo
            $('#typeField').hide();
            $('#scheduleFields').hide();

            // mostrar modal
            $('#createTaskModal').modal('show');
        });

        $('#createTaskModal').on('hidden.bs.modal', function () {

            $('#linkedTaskId').val('');
            $('#typeField').show();

        });

        function renderTaskTree(task, level = 0) {

            let html = `
                <div style="margin-left:${level * 20}px" class="mb-2">
                    <div class="d-flex align-items-center justify-content-between p-2 border rounded">
                        
                        <span>
                            ${'> '.repeat(level)} ${task.name}
                        </span>

                        <div>
                            <button class="btn btn-sm btn-dark edit-task" data-id="${task.id}">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button class="btn btn-sm btn-danger delete-task" data-id="${task.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                    </div>
                </div>
            `;

            if (task.linked_tasks && task.linked_tasks.length) {
                task.linked_tasks.forEach(child => {
                    html += renderTaskTree(child, level + 1);
                });
            }

            return html;
        }

        $('.show-linked').on('click', function(e){

            e.stopPropagation();

            const id = $(this).data('id');

            const rootTask = tasks.find(t => t.id == id);

            if (!rootTask) return;

            const html = renderTaskTree(rootTask);

            $('#linkedTasksContainer').html(html);

            $('#linkedTasksModal').modal('show');

        });
        $(document).on('click', '.edit-task', function(){
            console.log("editar");
            const id = $(this).data('id');

            const task = tasks.find(t => t.id == id);

            if (!task) return;

            // reutilizas tu lógica existente
            $('#taskName').val(task.name);
            $('#taskDescription').val(task.description);
            $('#taskPoints').val(task.points);

            $('#taskForm').attr('action', '/tasks/' + id);
            $('#formMethod').val('PUT');

            $('#linkedTasksModal').modal('hide');
            $('#createTaskModal').modal('show');
            currentTaskId = task.id;
            if(task.linked_task_id){
                // ocultar tipo
                $('#typeField').hide();
                $('#scheduleFields').hide();
            }
        });
        $(document).on('click', '.delete-task', function(){

            const id = $(this).data('id');

            if (!confirm('¿Eliminar tarea?')) return;

            fetch('/tasks/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(() => location.reload());
        });

        flatpickr("#taskStartDate", {
            locale: "es",
            dateFormat: "Y-m-d"
        });
        document.getElementById('filterType').addEventListener('change', applyFilters);
        document.getElementById('filterRoom').addEventListener('change', applyFilters);
        function applyFilters() {

            const type = document.getElementById('filterType').value;
            const room = document.getElementById('filterRoom').value;

            document.querySelectorAll('.task-item').forEach(card => {

                const cardType = card.dataset.type;
                const cardRoom = card.dataset.room;

                const matchesType = !type || cardType === type;
                const matchesRoom = !room || cardRoom === room;

                const visible = matchesType && matchesRoom;

                const col = card.closest('.col-12');

                col.style.display = visible ? '' : 'none';
            });
        }
        document.querySelectorAll('.delete-task-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const taskName = this.closest('.task-item')?.dataset.name || 'esta tarea';
                if (confirm(`¿Seguro que quieres eliminar ${taskName}?`)) {
                    this.submit();
                }
            });
        });
    </script>

@endpush