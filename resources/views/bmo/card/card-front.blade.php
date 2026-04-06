<!-- FRONT -->
<div class="card-face card-front">
    <div class="icon icon-card close-card mx-4 w-100 d-flex justify-content-end pe-5 " style="z-index: 999; position: absolute" id="closeUserCard" onclick="closeCard()">
        <i class="bi bi-x-lg " ></i>
    </div>
    <div class="text-black p-4 h-100 d-flex flex-column">

        <div class="d-flex h-100 align-items-start justify-content-between gap-3 mb-4 w-100">

            <div class="user-photo w-25">
                <img src="" id="userCardImg" class="user-img w-100 h-auto">
            </div>

            <div class="user-info w-75 d-flex flex-column justify-content-between">
                <h2 id="userCardName" class="text-uppercase"></h2>
                <p id="userCardPoints"></p>
                <p id="userCardTasksCompleted"></p>
            </div>

        </div>

        @include('bmo.card.card-footer')

    </div>

</div>