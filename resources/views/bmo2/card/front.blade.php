<style>
    .bmo-dni-front{
        background-image: url('/card/front_bg.png');
        background-size: cover;
        width: 100%;
        height: 100%;
        position: relative;
        contain: layout;
    }
    .bmo-dni-charm{
        width: 92px;
        height: 248px;
        position: absolute;
        top: 5px;
        left: 0px;
        z-index: 99;
    }
    .bmo-dni-img{
        width: 260px;
        height: 254px;
        position: absolute;
        top: 43px;
        left: 63px;
    }
    .bmo-dni-name{
        position: absolute;
        font-size: 4rem;
        top: 50px;
        left: 335px;
        width: 680px;
        height: 117px;
        text-align: center;
        align-items: center;
        align-content: center;
        text-transform: uppercase;
    }

    .bmo-dni-label{
        font-size: 1.5rem;
    }
    .bmo-dni-points{
        font-size: 2.5rem;
    }

    .bmo-dni-points-badge{
        position: absolute;
        width: 354px;
        height: 114px;
        top: 178px;
        left: 335px;
        display: flex;
        flex-direction: column;
        padding: 14px;
        align-items: center;
    }

    .bmo-dni-resume{
        width: 624px;
        height: 206px;
        position: absolute;
        top: 304px;
        left: 65px;
        display: flex;
    }
    .bmo-dni-resume-label{
        width: 100%!important;
        display: block;
        text-align: center;
        font-size: 1.1rem;
    }

    .bmo-dni-resume-separator{
            height: 80%;
        margin-top: 20px;
        border-color: #000;
        border: 2px solid;
    }

    .bmo-dni-insigne-badge{
        position: absolute;
        width: 315px;
        height: 330px;
        top: 180px;
        left: 700px;
        display: flex;
        flex-direction: column;
        padding: 14px;
        align-items: center;
    }
    
</style>
<div class="bmo-dni-front bmo-dni-container bmo-dni-clickable">
    <div class="container-fluid w-100 h-100">

        <img id="dniCharm" class="bmo-dni-charm" alt="DNI Charm">
        <img id="dniImg" class="bmo-dni-img" alt="DNI Icon">

        <div class="bmo-dni-name">
            <span>{{ $dniUser->name }}</span>
        </div>
        <div class="bmo-dni-points-badge">
            <span class="bmo-dni-label">PUNTOS</span>
            <span class="bmo-dni-points"> <img style="margin-bottom: 18px;" src="/card/coin.png" alt="Coin Icon">
                {{ $dniUser->current_month_points }}</span>
        </div>


        <div class="bmo-dni-resume">
            <div class="w-50 p-3">
                <span class="bmo-dni-resume-label">
                    TOTAL VICTORIAS
                </span>
                <span class="d-flex w-100 justify-content-center align-items-center"
                    style="font-size: 4rem; height: 90%;">
                    5
                </span>

            </div>
            <div class="bmo-dni-resume-separator"></div>
            <div class="w-50 p-3">
                <span class="bmo-dni-resume-label">
                    REINA DE
                </span>
                <span class="d-flex w-100 justify-content-center align-items-center" style="height: 90%;">
                    <img src="/icons/rooms/laundry.png" alt="Reina Icon" style="height: 100px; vertical-align: middle;">
                </span>
            </div>
        </div>

        <div class="bmo-dni-insigne-badge h-100">
            <span class="bmo-dni-label">INSIGNIAS</span>
            <div class="row px-2">
                @for($i = 0; $i < 6; $i++)
                    <div class="col-4 py-4">
                        <img style="opacity: 0.75;" src="/card/empty-insigne.png" alt="Empty Insigne">
                    </div>
                @endfor
            </div>
        </div>
        <div class="bmo-dni-close">
            <img src="/card/cross.png" alt="Close Icon" onclick="bmoApp.loadScreen('tasks')">
        </div>
    </div>
</div>