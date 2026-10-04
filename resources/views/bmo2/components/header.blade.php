<div class="header bmo-header">

    <div class="title">
        <img class="filterIcon" alt="" style="display:none; width: 100px; height: 100px;">
        </img>
    </div>

    <div class="nav-icons">

        <img class="sortIcon" src="/icons/header/task-down.png" alt="" style="height: 120px" onclick="bmoApp.toggleSort()">
        <img class="current-user-icon" src="" alt="" style="height: 120px" onclick="bmoApp.loadScreen('dni')">
        {{-- <img src="/icons/header/flash_moving.png" alt="" style="height: 120px" onclick="bmoApp.loadScreen('flash_moving')"> --}}
        <img src="/icons/header/TASK-ICON.png" alt="" style="height: 120px" onclick="bmoApp.loadScreen('tasks')">
        <img src="/icons/header/COMMUN-TASK-ICON.png" alt="" style="height: 120px" onclick="bmoApp.loadScreen('common_tasks')">
        <img src="/icons/header/FILTERS-ICON.png" alt="" style="height: 120px" onclick="bmoApp.loadScreen('filter')">
        @if($isRouletteDay ?? false)
            <img src="/icons/header/RULE-ICON-02.png" alt="" style="height: 120px;" onclick="bmoApp.loadScreen('roulette')">
        @endif
        <img src="/icons/header/EXIT-ICON.png" alt="" style="height: 120px" onclick="location.reload()">
    </div>

</div>