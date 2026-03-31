<!-- BACK -->
<div class="card-face card-back">

    <div class="p-4 h-100 d-flex flex-column justify-content-between">

        <div class="row">
            <div class="col-3 text-center">
                <img src="bmo-figth.png" class="w-100">
            </div>
            <div class="col-6 text-center">
                <div class="stats-container mt-4">

                    {{-- EJEMPLO STAT --}}
                    <div class="stat-row" data-left="70" data-right="50">

                        <div class="stat-label text-center pb-4 stat-text">
                            Tareas completadas
                        </div>

                        <div class="stat-bars d-flex align-items-center">

                            <div class="stat-left-wrapper w-50 d-flex align-items-center">
                                <span class="pe-2 stat-text">70</span><div class="stat-bar stat-left"></div>
                            </div>

                            <div class="stat-right-wrapper w-50 d-flex align-items-center">
                                <div class="stat-bar stat-right"></div><span class="ps-2 stat-text">50</span>
                            </div>

                        </div>

                    </div>

                    <div class="stat-row" data-left="40" data-right="80">
                        <div class="stat-label text-center pb-4 stat-text">
                            Puntos
                        </div>

                        <div class="stat-bars d-flex align-items-center">
                            <div class="stat-left-wrapper w-50 d-flex align-items-center">
                                <span class="pe-2 stat-text">40</span> <div class="stat-bar stat-left"></div>
                            </div>

                            <div class="stat-right-wrapper w-50 d-flex align-items-center">
                                <div class="stat-bar stat-right"></div><span class="ps-2 stat-text">80</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-3 text-center">
                <img src="bma-figth.png" class="w-100">
            </div>
        </div>

        @include('bmo.card.card-footer')

    </div>

</div>