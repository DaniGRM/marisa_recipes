<!-- BACK -->

@php
    $userPoints = 0;
    $userTasks = 0;
    foreach($users as $user){
        if($user->current_month_points > $userPoints)
        {
            $userWinner = $user->id;
        }
        $userPoints += $user->current_month_points;     
        $userTasks += $user->current_month_tasks;

        
    }

@endphp
<div class="card-face card-back">
    <div class="p-4 h-100 d-flex flex-column justify-content-between">

        <div class="row h-100 d-flex align-items-center">
            <h2 class="text-center">LA COMPETENSIA</h2>
        </div>
        <div class="row h-100 d-flex align-items-center">
            <div class="col-3 text-center">
                @if($userWinner == 1)<img src="crown.png" style="height: 50px">@endif
                <img src="bmo-figth.png" class="w-100">
            </div>
            <div class="col-6 text-center">
                <div class="stats-container mt-4">

                    {{-- EJEMPLO STAT --}}
                    <div class="stat-row" data-left="{{( $users[0]->current_month_points / $userPoints)*100 }}" data-right="{{( $users[1]->current_month_points / $userPoints)*100 }}">

                        <div class="stat-label text-center pb-4 stat-text">
                            Puntos
                        </div>

                        <div class="stat-bars d-flex align-items-center">

                            <div class="stat-left-wrapper w-50 d-flex align-items-center">
                                <span class="pe-2 stat-text">{{$users[0]->current_month_points}}</span><div class="stat-bar stat-left"></div>
                            </div>

                            <div class="stat-right-wrapper w-50 d-flex align-items-center">
                                <div class="stat-bar stat-right"></div><span class="ps-2 stat-text">{{ $users[1]->current_month_points }}</span>
                            </div>

                        </div>

                    </div>

                    <div class="stat-row" data-left="{{( $users[0]->current_month_tasks / $userTasks)*100 }}" data-right="{{( $users[1]->current_month_tasks / $userTasks)*100 }}">
                        <div class="stat-label text-center pb-4 stat-text">
                            Tareas completadas
                        </div>

                        <div class="stat-bars d-flex align-items-center">
                            <div class="stat-left-wrapper w-50 d-flex align-items-center">
                                <span class="pe-2 stat-text">{{ $users[0]->current_month_tasks }}</span> <div class="stat-bar stat-left"></div>
                            </div>

                            <div class="stat-right-wrapper w-50 d-flex align-items-center">
                                <div class="stat-bar stat-right"></div><span class="ps-2 stat-text">{{ $users[1]->current_month_tasks }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-3 text-center">
                @if($userWinner == 2)<img src="crown.png" style="height: 50px">@endif
                <img src="bma-figth.png" class="w-100">
            </div>
        </div>

        @include('bmo.card.card-footer')

    </div>

</div>