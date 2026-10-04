@extends('layouts.app')

@section('title', 'Castigos')

@section('content')

    <div class="top-actions">

        <h2 class="mb-0">
            Castigos
        </h2>

        <button class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createPunishmentModal"
            id="createPunishmentModalBtn">

            + Nuevo castigo

        </button>

    </div>

    <div class="row g-4">

        @forelse($punishments as $punishment)

            <div class="col-12 col-md-6 col-lg-3">

                <div class="card punishment-card task-card h-100 border-0 shadow-sm p-3 punishment-item"
                    data-id="{{ $punishment->id }}"
                    data-name="{{ $punishment->name }}"
                    data-description="{{ $punishment->description }}"
                >

                    <div class="d-flex flex-column h-100">

                        {{-- TITLE --}}
                        <h5 class="fw-semibold mb-2">
                            {{ $punishment->name }}
                        </h5>

                        {{-- DESCRIPTION --}}
                        @if($punishment->description)
                            <p class="small mb-3">
                                {{ $punishment->description }}
                            </p>
                        @endif

                        {{-- DELETE --}}
                        <div class="mt-auto d-flex justify-content-end">
                            <form method="POST" action="{{ route('punishments.destroy', $punishment->id) }}" class="delete-punishment-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar castigo">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        @empty

            <p class="text-muted">
                Todavía no hay castigos creados.
            </p>

        @endforelse

    </div>

    {{-- MODAL CREAR/EDITAR --}}
    @include('punishments.punishment-modal')

@endsection

@push('scripts')

    <script>
        $('.punishment-item').on('click', function () {

            const modal = $('#createPunishmentModal');

            // Cambiar acción del form
            const id = $(this).data('id');
            $('#punishmentForm').attr('action', '/punishments/' + id);
            $('#formMethod').val('PUT');

            // Rellenar campos
            $('#punishmentName').val($(this).data('name'));
            $('#punishmentDescription').val($(this).data('description'));

            // Mostrar modal
            modal.modal('show');
        });

        $('.punishment-item button').on('click', function (e) {
            e.stopPropagation();
        });

        $('#createPunishmentModal').on('hidden.bs.modal', function () {

            $('#punishmentForm').attr('action', '{{ route("punishments.store") }}');
            $('#formMethod').val('POST');

            $('#punishmentForm')[0].reset();

        });

        $('#createPunishmentModalBtn').on('click', function (e) {
            e.stopPropagation();
        });
    </script>

@endpush
