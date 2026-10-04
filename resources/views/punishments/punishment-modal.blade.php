<div class="modal fade" id="createPunishmentModal">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content rounded-4 border-0 shadow-lg">

            <div class="modal-header border-0">

                <h5>Nuevo castigo</h5>

                <button class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <form method="POST" action="{{ route('punishments.store') }}" id="punishmentForm">

                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Nombre
                        </label>

                        <input name="name" class="form-control" id="punishmentName" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Descripción
                        </label>

                        <textarea name="description" class="form-control" id="punishmentDescription"></textarea>

                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark rounded-pill px-4">Guardar</button>
                </div>

            </form>

        </div>

    </div>

</div>
