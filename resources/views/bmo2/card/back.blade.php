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