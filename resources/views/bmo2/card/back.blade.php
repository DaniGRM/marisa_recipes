<style>
    .bmo-dni-back {
        background-image: url('/card/back_bg.jpg');
    }
    .bmo-dni-crown.user1{
        position: absolute;
        top: 280px;
        left: 220px;
        z-index: 10;
    }
    .bmo-dni-crown.user2{
        position: absolute;
        top: 280px;
        right: 208px;
        z-index: 10;
    }
    .bmo-dni-stats{
        position: absolute;
        top: 380px;
        left: 380px;
        width: 346px;
        height: 170px;
    }

    .bmo-task-bar-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
        gap: 8px;
        padding: 0 4px;
    }

    .bmo-task-bar {
        display: flex;
        width: 100%;
        height: 90%;
        overflow: hidden;
        background: rgba(0,0,0,0.3);
        box-shadow: 0 2px 8px rgba(0,0,0,0.4), inset 0 1px 3px rgba(0,0,0,0.3);
        
        border: 4px solid #000;
        border-radius: 18px;
    }

    .bmo-task-bar-fill {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .bmo-task-bar-fill.user1 {
        background: #ee95a7;
    }

    .bmo-task-bar-fill.user2 {
        background: #3ba3c5;
    }


    .bmo-task-bar-pct {
        font-size: 2rem;
        font-weight: bold;
        color: #fff;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        pointer-events: none;
        white-space: nowrap;
    }
</style>
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
    if($userPoints == 0){
        $userPoints = 1;
    }
    if($userTasks == 0){
        $userTasks = 1;
    }

    if($users[0]->current_month_points == $users[1]->current_month_points){
        if($users[0]->current_month_tasks == $users[1]->current_month_tasks){
            unset($userWinner);
        }elseif($users[0]->current_month_tasks > $users[1]->current_month_tasks){
            $userWinner = 1;
        }else{
            $userWinner = 2;
        }
    }
@endphp
<div class="bmo-dni-back bmo-dni-container bmo-dni-clickable">
    <div class="container-fluid w-100 h-100">

        @if(isset($userWinner) && $userWinner == 2)
            <div class="bmo-dni-crown user1">
                <img src="/card/crown.png" style="height: 100px">
            </div>
        @endif
        <div class="bmo-dni-user-points user1">
            <span class="bmo-dni-user-points-label user1">CARMEN</span>
            <span class="bmo-dni-user-points-value">{{$users[1]->current_month_points}}</span>
        </div>
        <div class="bmo-dni-stats">
            @php
                $points1 = $users[1]->current_month_points;
                $points0 = $users[0]->current_month_points;
                $pct1 = round(($points1 / $userPoints) * 100);
                $pct0 = 100 - $pct1;
            @endphp
            <div class="bmo-task-bar-wrapper">
                <div class="bmo-task-bar">
                    <div class="bmo-task-bar-fill user1" style="width: {{ $pct1 }}%">
                        @if($pct1 >= 15)
                            <span class="bmo-task-bar-pct">{{ $pct1 }}%</span>
                        @endif
                    </div>
                    <div class="bmo-task-bar-fill user2" style="width: {{ $pct0 }}%">
                        @if($pct0 >= 15)
                            <span class="bmo-task-bar-pct">{{ $pct0 }}%</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if(isset($userWinner) && $userWinner == 1)
            <div class="bmo-dni-crown user2">
                <img src="/card/crown.png" style="height: 100px">
            </div>
        @endif
        <div class="bmo-dni-user-points user2">
            <span class="bmo-dni-user-points-label user2">DANIE</span>
            <span class="bmo-dni-user-points-value">{{$users[0]->current_month_points}}</span>
        </div>
        <div class="bmo-dni-close">
            <img src="/card/cross.png" alt="Close Icon" onclick="bmoApp.loadScreen('tasks')">
        </div>
    </div>
</div>