@extends('layouts.app')

@section('title','Planes Semanales')

@section('content')

<div class="top-actions d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Planes Semanales</h2>

    <form method="POST" action="{{ route('weekly_plans.generate') }}">
        @csrf
        <button class="btn btn-bmo px-4">
            + Generar nuevo plan
        </button>
    </form>
</div>

<div class="row g-4">

    @forelse($plans as $plan)
        <div class="col-12">
            <div class="card shadow-sm rounded-4 p-3">

                <h5 class="fw-semibold mb-3">{{ $plan->name }}</h5>

                <div class="row g-3">
                    @foreach($plan->recipes as $weeklyRecipe)
                        @php
                            $recipe = $weeklyRecipe->recipe;
                            $badgeClass = 'badge-type';
                            if($weeklyRecipe->type === 'weekly') {
                                $badgeClass .= '-' . $recipe->type; // badge-type-0,1,2
                            } else {
                                $badgeClass .= '-single';
                            }
                        @endphp

                        <div class="col-12 col-md-4">
                            <div class="card recipe-card h-100 p-3">

                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="fw-semibold text-start">{{ $recipe->name }}</h6>
                                    <span class="badge {{ $badgeClass }} text-white">
                                        @if($weeklyRecipe->type === 'weekly')
                                            {{ $recipeTypes[$recipe->type] }}
                                        @else
                                            Único
                                        @endif
                                    </span>
                                </div>

                                <p class="text-muted small mt-2">
                                    {{ $recipe->ingredients->pluck('name')->join(', ', ' y ') }}
                                </p>

                                @if($weeklyRecipe->type === 'weekly')
                                    <span class="badge bg-success mt-auto">Semanal</span>
                                @else
                                    <span class="badge bg-warning mt-auto">Único</span>
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    @empty
        <div class="col-12">
            <p class="text-muted">No hay planes semanales generados todavía.</p>
        </div>
    @endforelse

</div>

@endsection