@extends('layouts.app')

@section('title','Recetas')

@section('content')

<div class="top-actions">
    <h2 class="mb-0">Recetas</h2>

    <button class="btn btn-bmo px-4 create-recipe"
            data-bs-toggle="modal"
            data-bs-target="#createRecipeModal">
        + Nueva receta
    </button>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <select id="filterType" class="form-select">
            <option value="">Todos los tipos</option>
            @foreach($recipeTypes as $id => $type)
                <option value="{{ $id }}">{{ $type }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <select id="filterWeekly" class="form-select">
            <option value="">Todos</option>
            <option value="1">Semanal</option>
            <option value="0">Único</option>
        </select>
    </div>

    <div class="col-md-3">
        <input type="text" id="filterIngredient" class="form-control" placeholder="Buscar por ingrediente">
    </div>
</div>

<div class="row g-4">
    @foreach($recipes as $recipe)
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card recipe-card h-100 p-3 edit-recipe filterable"
            style="cursor:pointer"
            data-id="{{ $recipe->id }}"
            data-name="{{ $recipe->name }}"
            data-type="{{ $recipe->type }}"
            data-weekly="{{ $recipe->weekly }}"
            data-ingredients='@json($recipe->ingredients->pluck("name"))'>

                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="fw-semibold text-start">{{ $recipe->name }}</h5>
                    <span class="badge badge-type-{{$recipe->type}} text-white">{{$recipeTypes[$recipe->type]}}</span>
                </div>

                <p class="text-muted small mt-3">
                    {{ $recipe->ingredients->pluck('name')->join(', ', ' y ') }}
                </p>

                <div class="mt-auto">
                    @if($recipe->weekly)
                    <span class="badge bg-success"> Semanal </span>
                    @else
                    <span class="badge bg-warning"> Único </span>
                    @endif
                </div>

            </div>
        </div>
    @endforeach

</div>

<!-- MODAL -->
<div class="modal fade" id="createRecipeModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">

            <div class="modal-header border-0">
                <h5 class="modal-title">Nueva receta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" id="recipeForm" action="{{ route('recipes.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text"
                               name="name"
                               class="form-control rounded-3"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo</label>
                        <select name="type"
                                class="form-select"
                                id="typeSelect"
                                required>
                            <option value="">Seleccionar tipo</option>
                            @foreach($recipeTypes as $id => $type)
                                <option value="{{ $id }}">
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input"
                               type="checkbox"
                               name="weekly"
                               id="semanalSwitch"
                               value="1">
                        <label class="form-check-label" for="semanalSwitch">
                            Incluir en planificación semanal
                        </label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ingredientes</label>
                        <select name="ingredients[]"
                                class="form-select"
                                id="ingredientSelect"
                                multiple>
                            @foreach($ingredients as $ingredient)
                                <option value="{{ $ingredient->name }}">
                                    {{ $ingredient->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit"
                            class="btn btn-dark rounded-pill px-4">
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
     $(document).ready(function() {

        $('#typeSelect').select2({
            dropdownParent: $('#createRecipeModal'),
            width: '100%',
            placeholder: "Seleccionar tipo"
        });

        $('#ingredientSelect').select2({
            dropdownParent: $('#createRecipeModal'),
            tags: true,
            tokenSeparators: [','],
            width: '100%',
            placeholder: "Añadir ingredientes"
        });

        $('.edit-recipe').on('click', function() {

            let id = $(this).data('id');
            let name = $(this).data('name');
            let type = $(this).data('type');
            let weekly = $(this).data('weekly');
            let ingredients = $(this).data('ingredients');

            // Cambiar título
            $('.modal-title').text('Editar receta');

            // Cambiar action
            $('#recipeForm').attr('action', '/recipes/' + id);

            // Cambiar método
            $('#formMethod').val('PUT');

            // Rellenar campos
            $('input[name="name"]').val(name);
            $('#typeSelect').val(type).trigger('change');

            if (weekly) {
                $('#semanalSwitch').prop('checked', true);
            } else {
                $('#semanalSwitch').prop('checked', false);
            }

            // Ingredientes
            $('#ingredientSelect').val(null).trigger('change');

            if (ingredients.length) {
                ingredients.forEach(function(item){
                    if ($("#ingredientSelect option[value='" + item + "']").length === 0) {
                        $('#ingredientSelect').append(new Option(item, item, true, true));
                    }
                });
                $('#ingredientSelect').val(ingredients).trigger('change');
            }

            $('#createRecipeModal').modal('show');
        });
        $('.create-recipe').on('click', function() {

            $('.modal-title').text('Nueva receta');
            $('#recipeForm').attr('action', "{{ route('recipes.store') }}");
            $('#formMethod').val('POST');
            $('#recipeForm')[0].reset();
            $('#ingredientSelect').val(null).trigger('change');
        });

        function filterCards() {
            let type = $('#filterType').val();
            let weekly = $('#filterWeekly').val();
            let ingredientQuery = $('#filterIngredient').val().toLowerCase();

            $('.filterable').each(function(){
                let cardType = $(this).data('type').toString();
                let cardWeekly = $(this).data('weekly').toString();
                let cardIngredients = $(this).data('ingredients');

                let show = true;

                // Filtrar por tipo
                if(type && type !== cardType){
                    show = false;
                }

                // Filtrar por weekly
                if(weekly !== "" && weekly !== cardWeekly){
                    show = false;
                }

                // Filtrar por ingrediente
                if(ingredientQuery){
                    let found = cardIngredients.some(ing => ing.toLowerCase().includes(ingredientQuery));
                    if(!found){
                        show = false;
                    }
                }

                if(show){
                    $(this).parent().show();
                } else {
                    $(this).parent().hide();
                }
            });
        }

        $('#filterType, #filterWeekly').on('change', filterCards);
        $('#filterIngredient').on('input', filterCards);
    });
</script>
@endpush