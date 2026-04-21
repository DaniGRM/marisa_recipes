/**
 * Sistema de Flip de Tarjeta DNI - Módulo independiente
 * Maneja la lógica de rotación entre front y back de la tarjeta
 */

class CardDNIFlipper {
    constructor() {
        this.isFlipped = false;
        this.cardInner = null;
    }

    /**
     * Inicializa el flipper cuando se carga la pantalla dni
     */
    init() {
        this.cardInner = document.querySelector('.bmo-dni-card-inner');
        
        if (!this.cardInner) {
            console.warn('Contenedor .bmo-dni-card-inner no encontrado');
            return;
        }

        console.log('CardDNIFlipper inicializado:', this.cardInner);
        this.attachEventListeners();
    }

    /**
     * Adjunta los event listeners a la tarjeta
     */
    attachEventListeners() {
        const dniScreen = document.querySelector('[data-screen="dni"]');
        
        if (!dniScreen) return;

        // Agregar listener al contenedor de la tarjeta para click general
        dniScreen.addEventListener('click', (e) => {
            // Ignorar click si es en el botón close
            if (e.target.closest('.bmo-dni-close')) {
                return;
            }

            // Si el click es en la tarjeta, hacer flip
            if (this.cardInner && this.cardInner.contains(e.target)) {
                this.toggleFlip();
            }
        });
    }

    /**
     * Alterna el estado de flip de la tarjeta
     */
    toggleFlip() {
        if (!this.cardInner) return;

        this.cardInner.classList.toggle('flipped');
        this.isFlipped = this.cardInner.classList.contains('flipped');

        console.log('Toggle flip:', this.isFlipped);

        // Si se hace flip al back, opcionalmente ejecutar animaciones
        if (this.isFlipped) {
            setTimeout(() => {
                this.onBackVisible();
            }, 300); // Espera a que termine la rotación
        }
    }

    /**
     * Se ejecuta cuando el back es visible
     */
    onBackVisible() {
        // Aquí se pueden agregar animaciones del back si es necesario
        console.log('Back face visible');
    }

    /**
     * Vuelve a mostrar el front si está flipped
     */
    showFront() {
        if (this.isFlipped) {
            this.toggleFlip();
        }
    }

    /**
     * Vuelve a mostrar el back si está en front
     */
    showBack() {
        if (!this.isFlipped) {
            this.toggleFlip();
        }
    }
}

// Instancia global
const cardDNIFlipper = new CardDNIFlipper();
