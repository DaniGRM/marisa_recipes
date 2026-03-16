@extends('layouts.app')

@section('title','Seleccionar usuario')

@section('content')

<div class="text-center mb-5">
    <h1>¿Quién anda ahí?</h1>
</div>

<div class="row justify-content-center g-4">

    @foreach($users as $user)
        <div class="col-6 col-md-3">

            <form method="POST" action="{{ route('user.login') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <button class="card recipe-card w-100 p-4 text-center border-0">
                    @if($user->id == 1)
                        <img src="bmo.png">
                    @else
                        <img src="bma.png">
                    @endif
                    <span class="mt-2 fs-8">{{$user->name}}</span>

                </button>

            </form>

        </div>
    @endforeach

</div>

@endsection