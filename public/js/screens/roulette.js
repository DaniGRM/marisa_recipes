/**
 * Sistema de Ruleta de Castigos - Módulo independiente
 * Maneja el giro de la ruleta y la selección del castigo resultante
 */

class RouletteManager {
    constructor() {
        this.wheel = null;
        this.punishments = [];
        this.currentRotation = 0;
        this.spinning = false;
        this.isTie = false;
    }

    /**
     * Inicializa la ruleta al entrar en la pantalla
     */
    init() {
        this.wheel = document.getElementById('rouletteWheel');
        this.updateScoreboard();

        const result = document.getElementById('rouletteResult');
        if (result) result.style.display = 'none';

        const spinBtn = document.getElementById('rouletteSpinBtn');
        const tieMessage = document.getElementById('rouletteTieMessage');
        if (spinBtn) spinBtn.style.display = this.isTie ? 'none' : '';
        if (tieMessage) tieMessage.style.display = this.isTie ? '' : 'none';

        if (!this.wheel) return;

        this.punishments = JSON.parse(this.wheel.dataset.punishments || '[]');
        this.spinning = false;
    }

    /**
     * Muestra el nombre del usuario perdedor y el resultado de puntos del mes
     */
    updateScoreboard() {
        const loserNameEl = document.getElementById('rouletteLoserName');
        const pointsResultEl = document.getElementById('roulettePointsResult');
        const users = (typeof bmo !== 'undefined' && bmo.users) || [];

        if (!loserNameEl || !pointsResultEl || users.length < 2) return;

        const [userA, userB] = users;
        const pointsA = userA.current_month_points ?? 0;
        const pointsB = userB.current_month_points ?? 0;

        this.isTie = pointsA === pointsB;

        loserNameEl.textContent = this.isTie
            ? 'Empate'
            : `Perdedor: ${pointsA < pointsB ? userA.name : userB.name}`;

        pointsResultEl.textContent = `${userA.name} ${pointsA} - ${userB.name} ${pointsB}`;
    }

    /**
     * Gira la ruleta y muestra el castigo resultante al terminar
     */
    spin() {
        if (!this.wheel || this.spinning || this.punishments.length === 0 || this.isTie) return;

        this.spinning = true;

        const spinBtn = document.getElementById('rouletteSpinBtn');
        if (spinBtn) spinBtn.style.display = 'none';

        const result = document.getElementById('rouletteResult');
        if (result) result.style.display = 'none';

        const count = this.punishments.length;
        const anglePer = 360 / count;
        const winningIndex = Math.floor(Math.random() * count);

        // Ángulo para que el puntero (arriba, 0deg) quede sobre el centro del segmento ganador
        const winningMidAngle = (winningIndex + 0.5) * anglePer;
        const extraSpins = 4 + Math.floor(Math.random() * 3); // vueltas completas para efecto visual
        const targetRotation = this.currentRotation
            + (extraSpins * 360)
            + (360 - (this.currentRotation % 360))
            - winningMidAngle;

        this.currentRotation = targetRotation;
        this.wheel.style.transform = `rotate(${targetRotation}deg)`;

        const onSpinEnd = () => {
            this.wheel.removeEventListener('transitionend', onSpinEnd);
            this.spinning = false;
            this.showResult(this.punishments[winningIndex]);
        };
        this.wheel.addEventListener('transitionend', onSpinEnd);
    }

    showResult(punishment) {
        const result = document.getElementById('rouletteResult');
        const name = document.getElementById('rouletteResultName');
        const description = document.getElementById('rouletteResultDescription');

        if (name) name.textContent = punishment.name;
        if (description) description.textContent = punishment.description || '';
        if (result) result.style.display = 'block';
    }
}

// Instancia global
const rouletteManager = new RouletteManager();
