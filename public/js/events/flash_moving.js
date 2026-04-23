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
    nameElement.classList.add(range.class);
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
                showConfirmationScreen(selectedNumber);
            }, 2000);
        }, 1500); // 1.5 segundos de delay
    });
});

// Función para mostrar la pantalla de confirmación
function showConfirmationScreen(selectedNumber) {
    const totalPoints = selectedNumber;
    const totalPointsDisplay = document.getElementById('totalPointsDisplay');

    totalPointsDisplay.textContent = totalPoints;
    bmoApp.loadScreen('flash_moving_confirm');

    // Hacer AJAX para sumar los puntos
    setTimeout(() => {
        savePoints(totalPoints);
    }, 2000);
}

// Función AJAX para guardar los puntos
function savePoints(totalPoints) {
    fetch('/flash-moving/save-points', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({
            points: totalPoints
        })
    })
        .then(response => response.json())
        .then(data => {
            // Mostrar loader y recargar después
            bmoApp.showLoader();
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            bmoApp.showLoader();
            setTimeout(() => {
                location.reload();
            }, 2000);
        });
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