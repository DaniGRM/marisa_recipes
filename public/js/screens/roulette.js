const rouletteScreen = (() => {

    const PUNISHMENTS = [
        { label: 'FREGAR\nEL BAÑO',   color: '#e63946', text: '#fff' },
        { label: 'PASAR\nLA MOPA',    color: '#f4a261', text: '#1a1a2e' },
        { label: 'SACAR\nBASURA',     color: '#2a9d8f', text: '#fff' },
        { label: 'LIMPIAR\nCRISTALES',color: '#8338ec', text: '#fff' },
        { label: 'BARRER\nLA ENTRADA',color: '#fb5607', text: '#fff' },
    ];

    const TOTAL   = PUNISHMENTS.length;
    const SLICE   = (2 * Math.PI) / TOTAL;

    let canvas, ctx;
    let currentAngle = 0;  // ángulo actual de la ruleta
    let spinning     = false;
    let animFrame    = null;

    // ── Dibuja la ruleta en el canvas ───────────────────────────────────────
    function draw(angle) {
        const cx = canvas.width  / 2;
        const cy = canvas.height / 2;
        const r  = cx - 4;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        PUNISHMENTS.forEach((p, i) => {
            const start = angle + i * SLICE;
            const end   = start + SLICE;

            // Sector
            ctx.beginPath();
            ctx.moveTo(cx, cy);
            ctx.arc(cx, cy, r, start, end);
            ctx.closePath();
            ctx.fillStyle = p.color;
            ctx.fill();

            // Borde pixelado del sector
            ctx.strokeStyle = '#1a1a2e';
            ctx.lineWidth   = 3;
            ctx.stroke();

            // Texto (pixel-style con dos líneas si tiene \n)
            ctx.save();
            ctx.translate(cx, cy);
            ctx.rotate(start + SLICE / 2);
            ctx.textAlign    = 'right';
            ctx.fillStyle    = p.text;
            ctx.font = "20px 'Press Start 2P'";


            const lines = p.label.split('\n');
            const lineH = 20;
            const yBase = -(lines.length - 1) * lineH / 2;
            lines.forEach((line, li) => {
                ctx.fillText(line, r - 10, yBase + li * lineH + 4);
            });

            ctx.restore();
        });

        // Centro decorativo
        ctx.beginPath();
        ctx.arc(cx, cy, 18, 0, 2 * Math.PI);
        ctx.fillStyle   = '#ffe600';
        ctx.fill();
        ctx.strokeStyle = '#1a1a2e';
        ctx.lineWidth   = 3;
        ctx.stroke();
    }

    // ── Determina qué sector queda bajo el puntero (arriba = -π/2) ──────────
    function getResult(finalAngle) {
        const pointerAngle = -Math.PI / 2;
        // Normalizar: sector 0 empieza en `finalAngle`
        let rel = ((pointerAngle - finalAngle) % (2 * Math.PI) + 2 * Math.PI) % (2 * Math.PI);
        const idx = Math.floor(rel / SLICE) % TOTAL;
        return PUNISHMENTS[idx];
    }

    // ── Animación de giro ───────────────────────────────────────────────────
    function spin() {
        if (spinning) return;
        spinning = true;

        const btn = document.getElementById('spinBtn');
        if (btn) btn.disabled = true;

        const resultEl = document.getElementById('rouletteResult');
        if (resultEl) resultEl.style.display = 'none';

        // Vueltas totales: entre 5 y 8 vueltas completas + ángulo aleatorio
        const extraTurns = (5 + Math.random() * 3) * 2 * Math.PI;
        const targetAngle = currentAngle + extraTurns;

        const duration  = 4000; // ms
        const startTime = performance.now();
        const startAngle = currentAngle;

        function easeOut(t) {
            return 1 - Math.pow(1 - t, 4); // cuártica suave
        }

        function frame(now) {
            const elapsed  = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased    = easeOut(progress);

            currentAngle = startAngle + extraTurns * eased;
            draw(currentAngle);

            if (progress < 1) {
                animFrame = requestAnimationFrame(frame);
            } else {
                currentAngle = targetAngle;
                draw(currentAngle);
                spinning = false;
                showResult();
            }
        }

        animFrame = requestAnimationFrame(frame);
    }

    // ── Muestra el resultado ────────────────────────────────────────────────
    function showResult() {
        const punishment = getResult(currentAngle);
        const resultEl   = document.getElementById('rouletteResult');
        const btn        = document.getElementById('spinBtn');

        if (resultEl) {
            resultEl.textContent = punishment.label.replace('\n', ' ');
            resultEl.style.display     = 'block';
        }

        if (btn) btn.disabled = false;
    }

    // ── Init: se llama la primera vez que se entra a la pantalla ───────────
    function init() {
        canvas = document.getElementById('rouletteCanvas');
        if (!canvas) return;
        ctx = canvas.getContext('2d');
        draw(currentAngle);
    }

    // Exponer solo lo necesario
    return { init, spin };
})();   