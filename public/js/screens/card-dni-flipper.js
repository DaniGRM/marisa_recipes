class CardDNIFlipper {
    constructor() {
        this.isFlipped = false;
        this.cardInner = null;
        this._clickHandler = null; // Guardar referencia del handler
    }

    init() {
        this.isFlipped = false; // Resetear estado al reiniciar
        this.cardInner = document.querySelector('.bmo-dni-card-inner');
        
        if (!this.cardInner) {
            console.warn('Contenedor .bmo-dni-card-inner no encontrado');
            return;
        }

        console.log('CardDNIFlipper inicializado:', this.cardInner);
        this.attachEventListeners();
    }

    attachEventListeners() {
        const dniScreen = document.querySelector('[data-screen="dni"]');
        if (!dniScreen) return;

        // Eliminar listener anterior si existe antes de añadir uno nuevo
        if (this._clickHandler) {
            dniScreen.removeEventListener('click', this._clickHandler);
        }

        // Guardar referencia para poder eliminarlo después
        this._clickHandler = (e) => {
            if (e.target.closest('.bmo-dni-close')) return;

            if (this.cardInner && this.cardInner.contains(e.target)) {
                this.toggleFlip();
            }
        };

        dniScreen.addEventListener('click', this._clickHandler);
    }

    toggleFlip() {
        if (!this.cardInner) return;

        this.cardInner.classList.toggle('flipped');
        this.isFlipped = this.cardInner.classList.contains('flipped');

        if (this.isFlipped) {
            setTimeout(() => this.onBackVisible(), 300);
        }
    }

    onBackVisible() {
        console.log('Back face visible');
    }

    showFront() {
        if (this.isFlipped) this.toggleFlip();
    }

    showBack() {
        if (!this.isFlipped) this.toggleFlip();
    }

    /**
     * Limpieza al cerrar la card
     */
    destroy() {
        const dniScreen = document.querySelector('[data-screen="dni"]');
        if (dniScreen && this._clickHandler) {
            dniScreen.removeEventListener('click', this._clickHandler);
            this._clickHandler = null;
        }
        this.isFlipped = false;
        this.cardInner = null;
    }
}

const cardDNIFlipper = new CardDNIFlipper();