<style>
    .hints{
        width: 100%;
        display: flex;
        justify-content: space-between;
    }
</style>

<div class="bmo-screen" data-screen="gift_events_hints">
    @foreach ($giftData as $gift)
        @php
            $giftInfo = isset($gift['gift_event']) ? $gift['gift_event'] : $gift;
        @endphp
        <div style="    height: 60%;
        display: flex;
        justify-content: space-evenly;
        align-items: center;"
        id="gift{{ $giftInfo['id'] }}"
        class="gift-hints-wrapper">
            <div class="hints">

                <button  style="background-color: transparent; border-color: transparent; @if(isset($gift['used_text']) && $gift['used_text']) opacity: 0.5; @endif " class="hint" data-type="text" data-src="{{$giftInfo['hint_text'] ?? ''}}"><img style="width: 250px" src="/card/pencil.png" alt=""></button>
                <button style="background-color: transparent; border-color: transparent;  @if(isset($gift['used_image']) && $gift['used_image']) opacity: 0.5; @endif " class="hint" data-type="image" data-src="{{ $giftInfo['hint_image'] ?? '' }}"><img style="width: 250px" src="/card/image.png" alt=""></button>
                <button style="background-color: transparent; border-color: transparent; @if(isset($gift['used_sound']) && $gift['used_sound']) opacity: 0.5; @endif " class="hint" data-type="sound" data-src="{{ $giftInfo['hint_sound'] ?? '/card/audiohint1.mp3' }}"><img style="width: 250px" src="/card/speaker.png" alt=""></button>

            </div>
        </div>
    @endforeach
    <span style="font-size: 2rem; margin-bottom: 20px;">Por <span id="giftPoints">30</span> puntos</span>
    <button class="confirm-button" style="width:90%; height: 150px; font-size: 3rem;" id="completeGift">He acertado</button>
    <div class="bmo-dni-close" style="right: 62px;top: 53px;">
            <img src="/card/cross.png" alt="Close Icon" onclick="bmoApp.loadScreen('tasks')">
        </div>
    </div>

    <!-- Modal for hints -->
    <div id="hintModal" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
        <div style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 600px;">
            <span class="close" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
            <div id="modalBody"></div>
        </div>
    </div>

    <!-- Audio player for sounds -->
    <audio id="audioPlayer" style="display: none;"></audio>
    
</div>

<script>
    // Función para calcular puntos basados en pistas usadas
    function calculatePoints(usedHints) {
        switch (usedHints) {
            case 0: return 30;
            case 1: return 20;
            case 2: return 15;
            default: return 10;
        }
    }
    
    function recalculatePointsForCurrentGift() {
        const currentGift = document.getElementById('currentGift').value;
        const giftWrapper = document.getElementById('gift' + currentGift);
        
        if (!giftWrapper) return;

        const usedHintsForGift = giftWrapper.querySelectorAll('.hint[data-used="true"]').length;
        document.getElementById('giftPoints').textContent = calculatePoints(usedHintsForGift);
    }
    let usedHints = 0;

    // Contar pistas ya usadas al cargar
    document.querySelectorAll('.hint').forEach(btn => {
        if (btn.style.opacity === '0.5') {
            usedHints++;
            btn.dataset.used = 'true'; // Marcar como usada
        }
    });

    // Actualizar puntos iniciales
    document.getElementById('giftPoints').textContent = calculatePoints(usedHints);

    document.querySelectorAll('.hint').forEach(btn => {
        btn.addEventListener('click', function () {
            // if (this.dataset.used === 'true') return;

            const type = this.dataset.type;
            const src = this.dataset.src;
            const currentGift = document.getElementById('currentGift').value;

            fetch(`/bmo/gift/${currentGift}/hint/${type}?userId=${bmo.selectedUser}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            this.dataset.used = 'true';
            this.style.opacity = 0.5;

            // Recalcular basándose en el regalo activo, no en un contador global
            recalculatePointsForCurrentGift();

            if (type === 'text') {
                document.getElementById('modalBody').innerHTML = '<p style="font-size: 7rem;">' + src + '</p>';
                document.getElementById('hintModal').style.display = 'block';
            } else if (type === 'image') {
                document.getElementById('modalBody').innerHTML = '<img style="width: 500px;" src="' + src + '">';
                document.getElementById('hintModal').style.display = 'block';
            } else if (type === 'sound') {
                const audio = document.getElementById('audioPlayer');
                audio.src = src;
                audio.play();
            }
        });
    });

    // Close modal when clicking the close button
    document.querySelector('.close').addEventListener('click', () => {
        document.getElementById('hintModal').style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', (event) => {
        const modal = document.getElementById('hintModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    document.getElementById('completeGift').addEventListener('click', () => {
        const currentGift = document.getElementById('currentGift').value;
        window.location.href = `/bmo/gift/${currentGift}/complete?userId=${bmo.selectedUser}`;
    });
</script>