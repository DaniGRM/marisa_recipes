<div id="user-card-screen" class="bmo-overlay" style="display: none;">


    <div id="user-card-info-screen" class="bmo-screen active">

        <div class="user-card-container text-black p-4">

            <div class="d-flex h-100 align-items-start justify-content-between gap-3 mb-4 w-100">

                <div class="user-photo w-25">
                    <img src="" alt="Usuario" id="userCardImg" class="user-img w-100 h-auto" style="object-fit:cover;">
                </div>


                <div
                    class="user-info w-75 p-6 h-100 d-flex flex-column flex-wrap align-content-between justify-content-between">
                    <h2 id="userCardName" class="mb-2 text-uppercase"></h2>
                    <p id="userCardPoints">0 <i class="bi bi-coin"></i> </p>
                    <p id="userCardTasksCompleted">Tareas completadas: 0</p>
                </div>
            </div>


            <div class="text-end mt-auto d-flex justify-content-between">
                <div class="icon reverse-card mx-4">
                    <i class="bi bi-repeat"></i>
                </div>
                <button id="closeUserCard" class="btn btn-light rounded-pill px-4">Volver</button>
            </div>

        </div>

    </div>

</div>