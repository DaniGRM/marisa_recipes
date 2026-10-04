<div class="bmo-screen" data-screen="roulette">

    <div class="roulette-close">
        <img src="/card/cross.png" alt="Cerrar" onclick="bmoApp.loadScreen('tasks')">
    </div>

    <div class="roulette-layout d-flex h-100">

        <div class="roulette-wheel-side d-flex align-items-center justify-content-center">

            @if($punishments->isEmpty())

                <p class="roulette-empty text-center">
                    No hay castigos creados todavía.
                </p>

            @else

                @php
                    $rouletteColors = ['#ef476f', '#ffd166', '#06d6a0', '#118ab2', '#073b4c', '#7209b7', '#f3722c', '#90be6d'];
                    $rouletteCount = $punishments->count();
                    $rouletteAnglePer = 360 / $rouletteCount;
                    $rouletteGradientParts = [];
                    foreach ($punishments as $i => $punishment) {
                        $color = $rouletteColors[$i % count($rouletteColors)];
                        $start = $i * $rouletteAnglePer;
                        $end = ($i + 1) * $rouletteAnglePer;
                        $rouletteGradientParts[] = "{$color} {$start}deg {$end}deg";
                    }
                    $rouletteGradientCss = 'conic-gradient(' . implode(', ', $rouletteGradientParts) . ')';
                    $roulettePunishmentsData = $punishments->map(fn($p) => ['name' => $p->name, 'description' => $p->description])->toJson();
                @endphp

                <div class="roulette-wheel-wrapper">

                    <div class="roulette-pointer"></div>

                    <div class="roulette-wheel" id="rouletteWheel" style="background: {{ $rouletteGradientCss }};"
                        data-punishments="{{ $roulettePunishmentsData }}">

                        @foreach($punishments as $i => $punishment)
                            @php
                                $midAngle = ($i + 0.5) * $rouletteAnglePer;
                                // El conic-gradient mide 0deg desde arriba, pero rotate() de la etiqueta
                                // parte apuntando a la derecha, así que hay que corregir el desfase de 90deg
                                $labelAngle = $midAngle - 90;
                            @endphp
                            <div class="roulette-label" style="transform: rotate({{ $labelAngle }}deg);">
                                <span>{{ $punishment->name }}</span>
                            </div>
                        @endforeach

                    </div>

                </div>

            @endif

        </div>

        <div class="roulette-info-side d-flex flex-column align-items-center">

            <div class="roulette-board">

                <h2 class="roulette-title">Ruleta de la polla</h2>

                <div class="roulette-board-row">
                    <i class="bi bi-emoji-dizzy-fill"></i>
                    <span id="rouletteLoserName"></span>
                </div>

                <div class="roulette-board-row">
                    <i class="bi bi-trophy-fill"></i>
                    <span id="roulettePointsResult"></span>
                </div>

                @unless($punishments->isEmpty())

                    <button class="roulette-spin-btn mt-2" id="rouletteSpinBtn" onclick="bmoApp.spinRoulette()">
                        Girar
                    </button>

                    <p class="roulette-tie-message mt-2" id="rouletteTieMessage" style="display:none;">
                        ¡Empate! Nadie gira la ruleta.
                    </p>

                    <div class="roulette-result mt-2" id="rouletteResult" style="display:none;">
                        <p class="roulette-result-name mb-2" id="rouletteResultName"></p>
                        <p class="roulette-result-description mb-0" id="rouletteResultDescription"></p>
                    </div>

                @else

                    <p class="roulette-board-empty mt-2">
                        No hay castigos disponibles para girar.
                    </p>

                @endunless

            </div>

        </div>

    </div>
</div>
