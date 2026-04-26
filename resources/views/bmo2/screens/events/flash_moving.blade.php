<link rel="stylesheet" href="{{ asset('css/events/flash_moving.css') }}">
<div class="bmo-screen" data-screen="flash_moving">
    <h1 class="flash-title">Elige una caja</h1>
    <div class="row h-100">
        @for ($i = 0; $i < 3; $i++)
            <div class="col-4 present-wrapper">
                <canvas class="gift-canvas"></canvas>
                <div class="present">
                    <div class="name"></div>

                    <div class="rotate-container">
                        <div class="bottom"></div>
                        <div class="front"></div>
                        <div class="left"></div>
                        <div class="back"></div>
                        <div class="right"></div>

                        <div class="lid">
                            <div class="lid-top"></div>
                            <div class="lid-front"></div>
                            <div class="lid-left"></div>
                            <div class="lid-back"></div>
                            <div class="lid-right"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
    <div class="row justify-content-between align-items-center h-25" style="margin-bottom: 20px;">
        @foreach($users as $user)
            <div class="fm-player-card col-6 fm-player-card--{{ $loop->first ? 'left' : 'right' }}">
                <div class="fm-player-card__avatar">
                    <img src="{{ $user->id == 1 ? '/bmo-dni.png' : '/bma-dni.png' }}" alt="{{ $user->name }}">
                </div>
                <div>
                    <div class="fm-player-card__name">{{ $user->name }}</div>
                        <div class="fm-player-card__stats">
                            <div class="fm-player-card__stat">
                                <img src="card/box.png" alt="cajas">
                                <span>{{ $user->flash_moving_boxes }}</span>
                            </div>
                            <div class="fm-player-card__stat">
                                <img src="card/coin.png" alt="puntos">
                                <span>{{ $user->flash_moving_points }}</span>
                            </div>
                        </div>
                </div>
                
            </div>
        @endforeach
        <div class="bmo-dni-close" style=" position: absolute; top: 60px; left: 1110px;">
            <img src="/card/cross.png" alt="Close Icon" onclick="bmoApp.loadScreen('tasks')">
        </div>
    </div>
</div>


<form id="formSelectGift" method="POST" action="/bmo/flash-moving/select-gift" style="display: none;">
    @csrf
    <input type="hidden" id="giftPoints" name="points" value="">
    <input type="hidden" id="userId" name="user_id" value="">
</form>

<script>
    // Generar números aleatorios por rango para cada regalo
    const presents = document.querySelectorAll('.present');
    const randomNumbers = [];
    let selectedNumber = 0;
    const ranges = [
        { min: 1, max: 2, class: 'range-low' },      // 1-2: Rojo
        { min: 3, max: 6, class: 'range-mid' },      // 3-6: Amarillo
        { min: 7, max: 10, class: 'range-high' }     // 7-10: Verde
    ];

    // Mezclar los rangos aleatoriamente
    const shuffledRanges = ranges.sort(() => Math.random() - 0.5);

    presents.forEach((present, index) => {
        const range = shuffledRanges[index];
        const randomNum = Math.floor(Math.random() * (range.max - range.min + 1)) + range.min;
        randomNumbers.push(randomNum);

        const nameElement = present.querySelector('.name');
        nameElement.textContent = randomNum + 'pts';
        
        // Si es 10, clase especial dorada; si no, la del rango
        if (randomNum === 10) {
            console.log('¡Jackpot! Número 10 asignado.');
            nameElement.classList.add('range-jackpot');
        } else {
            console.log(`Número ${randomNum} asignado al regalo ${index + 1} (Rango: ${range.class})`);
            nameElement.classList.add(range.class);
        }
    });

    // Manejar click en cada regalo
    let giftOpened = false;
    presents.forEach((present, clickedIndex) => {
        present.addEventListener('click', () => {

            if (giftOpened) return; // Evitar múltiples clics
            giftOpened = true;

            // Abrir el regalo clickeado
            present.classList.add('open');
            selectedNumber = randomNumbers[clickedIndex];

            // Con delay, abrir los otros dos
            setTimeout(() => {
                presents.forEach((otherPresent, index) => {
                    if (index !== clickedIndex) {
                        otherPresent.classList.add('open');
                    }
                });

                // Después de 2 segundos más, mostrar la pantalla de confirmación
                setTimeout(() => {
                    selectGift(selectedNumber);
                }, 3000);
            }, 1500); // 1.5 segundos de delay
        });
    });

    // Función para seleccionar regalo (similar a completeTask en bmo2.js)
    function selectGift(points) {
        bmoApp.showLoader();
        const form = document.getElementById('formSelectGift');
        const pointsInput = document.getElementById('giftPoints');
        const userIdInput = document.getElementById('userId');
        pointsInput.value = points;
        userIdInput.value = bmo.selectedUser;
        form.submit();
    }

    // Sistema de nieve para cada canvas
    document.querySelectorAll('.gift-canvas').forEach(canvas => {
        const ctx = canvas.getContext('2d');
        let width, height, lastNow;
        let snowflakes;
        let maxSnowflakes = 100;

        function init() {
            snowflakes = [];
            resize();
            render(lastNow = performance.now());
        }

        function render(now) {
            requestAnimationFrame(render);

            const elapsed = now - lastNow;
            lastNow = now;

            ctx.clearRect(0, 0, width, height);
            if (snowflakes.length < maxSnowflakes)
                snowflakes.push(new Snowflake());

            ctx.fillStyle = ctx.strokeStyle = 'rgba(255, 255, 255, .5)';

            snowflakes.forEach(snowflake => snowflake.update(elapsed, now));
        }

        class Snowflake {
            constructor() {
                this.spawn();
            }

            spawn(anyY = false) {
                this.x = rand(0, width);
                this.y = anyY === true
                    ? rand(-50, height + 50)
                    : rand(-50, -10);
                this.xVel = rand(-.05, .05);
                this.yVel = rand(.02, .1);
                this.angle = rand(0, Math.PI * 2);
                this.angleVel = rand(-.001, .001);
                this.size = rand(7, 12);
                this.sizeOsc = rand(.01, .5);
            }

            update(elapsed, now) {
                const xForce = rand(-.001, .001);

                if (Math.abs(this.xVel + xForce) < .075) {
                    this.xVel += xForce;
                }

                this.x += this.xVel * elapsed;
                this.y += this.yVel * elapsed;
                this.angle += this.xVel * 0.05 * elapsed;

                if (
                    this.y - this.size > height ||
                    this.x + this.size < 0 ||
                    this.x - this.size > width
                ) {
                    this.spawn();
                }

                this.render();
            }

            render() {
                ctx.save();
                const { x, y, angle, size } = this;
                ctx.beginPath();
                ctx.arc(x, y, size * 0.2, 0, Math.PI * 2, false);
                ctx.fill();
                ctx.restore();
            }
        }

        // Utils
        const rand = (min, max) => min + Math.random() * (max - min);

        function resize() {
            width = canvas.width = canvas.parentElement.offsetWidth;
            height = canvas.height = canvas.parentElement.offsetHeight;
            maxSnowflakes = Math.max(width / 10, 50);
        }

        window.addEventListener('resize', resize);
        init();
    });
</script>