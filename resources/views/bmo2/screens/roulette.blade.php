<div class="bmo-screen" data-screen="roulette">
    <div class="roulette-container">
        <div class="roulette-wheel-wrapper" onclick="rouletteScreen.spin()">
            <div class="roulette-pointer"></div>
            <canvas id="rouletteCanvas" width="500" height="500"></canvas>
        </div>

        <div id="rouletteResult" class="roulette-result pixel-text" style="display:none;"></div>
    </div>
    <div class="roulette-card-container" style="    background-image: url('/card/roulette_resume_bg.png');
    background-size: cover;
    height: 540px;
    width: 500px;
    top: 90px;
    right: 104px;">

    </div>
    <div class="bmo-dni-close" style=" position: absolute; top: 60px; left: 1110px;">
        <img src="/card/cross.png" alt="Close Icon" onclick="bmoApp.loadScreen('tasks')">
    </div>
</div>