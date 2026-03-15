@extends('layouts.app')

@section('title','Inicio')

@section('content')

<div class="hero text-center mb-5">

    <h1 class="mb-3">
        Planificador de comidas
    </h1>

    <p class="lead">
        Organiza automáticamente el menú semanal y genera tu lista de la compra.
    </p>

    
    @if($latestPlan)
    <hr>
        <div class="row g-4">
            <div class="col-12">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="fw-semibold text-center">Semana actual</h4>
                    <form method="POST" action="{{ route('weekly_plans.generate') }}">
                        @csrf
                        <button class="btn btn-bmo btn-lg">
                            Crear semana
                        </button>
                    </form>
                </div>
                <div class="row g-3">
                    @foreach($latestPlan->recipes as $weeklyRecipe)
                        @php
                            $recipe = $weeklyRecipe->recipe;
                            $badgeClass = 'badge-type';
                            if($weeklyRecipe->type === 'weekly') {
                                $badgeClass .= '-' . $recipe->type;
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

                                <p class="text-muted small mt-2 text-start">
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
    @else
        <p class="text-center text-muted">No hay semanas generadas todavía.</p>
    @endif
</div>

@endsection