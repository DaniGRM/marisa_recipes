<div class="modal fade" id="createTaskModal">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content rounded-4 border-0 shadow-lg">

            <div class="modal-header border-0">

                <h5>Nueva tarea</h5>
                
                <button class="btn-close" data-bs-dismiss="modal"></button>

            </div>
            <div class="row d-flex justify-content-start">
                <div class="col-3 ps-4">
                    <button type="button"
                            class="btn btn-outline-dark"
                            id="createLinkedTaskBtn">
                        + Tarea enlazada
                    </button>
                </div>
                
            </div>
            

            <form method="POST" action="{{route('tasks.store')}}" id="taskForm">

                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="linked_task_id" id="linkedTaskId">
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

                    <div class="mb-3" id="typeField">

                        <label class="form-label">

                            Tipo

                        </label>

                        <select name="type" class="form-select" id="typeSelect">

                            @foreach($types as $id => $type)

                                <option value="{{$id}}">

                                    {{$type}}

                                </option>

                            @endforeach

                        </select>

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Habitación</label>

                        <select name="room" id="roomSelect" class="form-select" required>

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
                                style="width:80px" value="1" min="1" id="taskEvery">

                            <select name="frequency" class="form-select" style="width:150px" id="taskFrequency">

                                @foreach($frequencies as $id => $frequency)
                                    <option value="{{$id}}">
                                        {{$frequency}}
                                    </option>
                                @endforeach

                            </select>

                        </div>
                        <div class="mt-3">
                        <label class="form-label">Fecha de inicio</label>

                        <input type="text"
                        name="start_date"
                        id="taskStartDate"
                        class="form-control"
                        placeholder="Seleccionar fecha">
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