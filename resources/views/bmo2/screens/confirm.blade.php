<div class="bmo-screen" data-screen="confirm">
    <div class="loader-content d-flex flex-column justify-content-around h-100">

        <div class="bmo-message">
            Estas segur@ de completar la tarea?
            <br>
            <span id="taskDescription" class="confirm-description"></span>
        </div>
        <div id="confirmTaskBtn" class="bmo-message d-flex" >
            <button class="confirm-button" id="confirmTaskBtn" onclick="bmoApp.completeTask()">SI</button>
            <button class="confirm-button" onclick="bmoApp.cancelCompleteTask()">NO</button>
        </div>

    </div>
</div>